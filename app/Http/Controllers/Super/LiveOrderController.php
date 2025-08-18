<?php

namespace App\Http\Controllers\SUPER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TableClasses;
use App\Models\Tables;
use App\Models\Orders;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\File;
use Sentinel;
use DataTables;
use App\Notifications\OrderApprovedNotification;
use App\Notifications\OrderReadyToServeNotification;
use Illuminate\Support\Facades\Notification;

class LiveOrderController extends Controller
{
    public function index() {
      $table_classes = TableClasses::all();
        return view('Admin.SUPER.order-live.index',compact(['table_classes']));
    }

    public function getOrderList(Request $req) {
      $table_class_id = $req->table_class; 
      $user = Sentinel::getUser();
      if ($req->ajax()) {
            $data = Orders::with(['table.tableClass','details'])
            ->whereHas('table', function ($q) use ($table_class_id) {
                $q->whereHas('tableClass', function ($q2) use ($table_class_id) {
                    if($table_class_id != "all") {
                        $q2->where('id', $table_class_id);
                    }
                });
            })
            ->where(function ($q) use ($user){
              if(!$user->inRole('koki')){
                $q->where('status','!=','served')
                ->where('status','!=','rejected');
              }else{
                $q->where('status','=','approved');
              }
            })                        
            ->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_item',function($row){
                  return $row->details->count();
                })
                ->addColumn('action', function($row){
                  $user = Sentinel::getUser();
                  if(!$user->inRole('koki')){
                    if($row->payment_status=="paid"){
                      if($row->status=="ready-to-serve"){
                        return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>
                        <button class="btn btn-sm btn-secondary btn-done" data-id="'.$row->id.'">Mark as Done</button>
                        <a href="'.route('kasir.live-order.nota', $row->id).'" target="_blank" class="btn btn-sm btn-dark">Print Nota</a>
                        ';
                      }else{
                        return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>
                                <a href="'.route('kasir.live-order.nota', $row->id).'" target="_blank" class="btn btn-sm btn-dark">Print Nota</a>
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
                  }else{
                    if($row->status=="approved"){
                      return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>
                      <button class="btn btn-sm btn-warning btn-ready-to-serve" data-id="'.$row->id.'">Ready to Serve?</button>
                      ';
                    }else{
                      return '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">Detail</button>
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
                  }else if($row->status=='ready-to-serve'){
                    return '<span class="badge badge-primary text-md">'.$row->status.'</span>';
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
        $order->load('details.menu', 'table');
        return response()->json($order);
    }
    
    public function invoice(Orders $order)
    {
        $order->load('details.menu', 'table');
        return response()->json($order);
    }

    public function nota(Orders $order)
    {
        $order->load('details.menu', 'table');
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
        // send notification
        // ambil role koku
        $kokiRole = Sentinel::findRoleBySlug('koki');
        $kokis = $kokiRole ? $kokiRole->users()->with('roles')->get() : collect();

        Notification::send($kokis, new OrderApprovedNotification($order));

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
        $table = Tables::where('id',$order->table_id)->first();
        $table->status = 'available';
        $table->save();

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

    public function ready(Request $request, Orders $order)
    {
        // update status order
        $order->update([
          'validator_id'=>Sentinel::getUser()->id,
            'status' => 'ready-to-serve', 
        ]);

         // ambil role admin
         $adminRole = Sentinel::findRoleBySlug('super-admin');
         $admins = $adminRole ? $adminRole->users()->with('roles')->get() : collect();

         // ambil role kasir
         $kasirRole = Sentinel::findRoleBySlug('admin');
         $kasirs = $kasirRole ? $kasirRole->users()->with('roles')->get() : collect();

         // gabungkan
         $users = $admins->merge($kasirs);
         Notification::send($users, new OrderReadyToServeNotification($order));

        // kalau request ajax
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Order berhasil diupdate status untuk siap dihidangkan!',
            ]);
        }

        // kalau bukan ajax
        return redirect()->back()->with('success', 'Order berhasil diupdate status untuk siap dihidangkan!');
    }

    public function done(Request $request, Orders $order)
    {
        // update status order
        $order->update([
          'validator_id'=>Sentinel::getUser()->id,
            'status' => 'served', 
        ]);

        $table = Tables::where('id',$order->table_id)->first();
        $table->status = 'available';
        $table->save();

        // kalau request ajax
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Order berhasil diselesaikan!',
            ]);
        }

        // kalau bukan ajax
        return redirect()->back()->with('success', 'Order berhasil diselesaikan!');
    }
}
