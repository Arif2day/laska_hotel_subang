<?php

namespace App\Http\Controllers\SUPER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlaceCategories;
use App\Models\Places;
use App\Models\Orders;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\File;
use Sentinel;
use DataTables;

class RiwayatOrderController extends Controller
{
    public function index() {
      $place_categories = PlaceCategories::all();
        return view('Admin.SUPER.order-riwayat.index',compact(['place_categories']));
    }

    public function getOrderList(Request $req) {
        $place_category_id = $req->place_category; 
        if ($req->ajax()) {
          $data = Orders::with(['place.placeCategory','details'])
          ->whereHas('place', function ($q) use ($place_category_id) {
            $q->whereHas('placeCategory', function ($q2) use ($place_category_id) {
              if($place_category_id != "all") {
                $q2->where('id', $place_category_id);
              }
            });
          })
          ->whereIn('status', ['served', 'rejected'])
          ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_item',function($row){
                  return $row->details->count();
                })
                ->addColumn('action', function($row){
                    if($row->payment_status=="paid"){
                      if(!Sentinel::getUser()->inRole('koki')){
                        return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>
                        <a href="'.route('kasir.live-order.nota', $row->id).'" target="_blank" class="btn btn-sm btn-dark">Print Nota</a>
                        ';
                      }else{
                        return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>                          
                        ';
                      }
                    }else{
                      if($row->status=="served"){
                        return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>
                                <a href="'.route('kasir.live-order.nota', $row->id).'" target="_blank" class="btn btn-sm btn-dark">Print Nota</a>
                                ';
                      }else if($row->status=="rejected"){
                        return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>
                        ';
                      }else{
                        return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>
                                <button class="btn btn-sm btn-success btn-pay" data-id="'.$row->id.'">Bayar</button>
                                <button class="btn btn-sm btn-danger btn-cancel" data-id="'.$row->id.'">Cancel</button>
                                <a href="'.route('kasir.live-order.nota', $row->id).'" target="_blank" class="btn btn-sm btn-dark">Print Nota</a>
                                ';
                      }
                    }
                  })
                ->editColumn('total_amount', function($row) {
                    return number_format($row->total_amount, 0, ',', '.');
                  })
                ->editColumn('status', function($row) {
                  if($row->status=='pending'){
                    return '<span class="badge badge-warning text-md">'.$row->status.'</span>';
                  }else if($row->status=='rejected'){
                    return '<span class="badge badge-danger text-md">'.$row->status.'</span>';
                  }else{
                    return '<span class="badge badge-success text-md">'.$row->status.'</span>';
                  }
                })
                ->editColumn('payment_status', function($row) {
                  if($row->payment_status=='unpaid'){
                    return '<span class="badge badge-warning text-md">'.$row->payment_status.'</span>';
                  }else{
                    return '<span class="badge badge-success text-md">'.$row->payment_status.'</span>';
                  }
                })
                ->rawColumns(['action','status','payment_status'])
                ->make(true);
          }
    }

    public function detail(Orders $order)
    {
        $order->load('details.menu', 'place');
        return response()->json($order);
    }
    
    public function invoice(Orders $order)
    {
        $order->load('details.menu', 'place');
        return response()->json($order);
    }

    public function nota(Orders $order)
    {
        $order->load('details.menu', 'place');
        return view('Admin.SUPER.order-live.nota', compact('order'));
    }

    public function payment(Request $request, Orders $order)
    {
        // update status order
        $order->update([
            'validator_id'=>Sentinel::getUser()->id,
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'status' => 'approved', 
        ]);

        // kalau request ajax
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dicatat!',
            ]);
        }

        // kalau bukan ajax
        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function cancel(Request $request, Orders $order)
    {
        // update status order
        $order->update([
          'validator_id'=>Sentinel::getUser()->id,
            'status' => 'rejected', 
        ]);
        $place = Places::where('id',$order->place_id)->first();
        $place->status = 'available';
        $place->save();

        // kalau request ajax
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibatalkan!',
            ]);
        }

        // kalau bukan ajax
        return redirect()->back()->with('success', 'Order berhasil dibatalkan!');
    }
}
