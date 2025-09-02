<?php

namespace App\Http\Controllers\SUPER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlaceCategories;
use App\Models\Places;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Sentinel;
use DataTables;
use Str;

class PlaceController extends Controller
{
    public function index() {
      $place_categories = PlaceCategories::all();
        return view('Admin.SUPER.place.index',compact(['place_categories']));
    }

    public function getPlaceList(Request $req) {
        if ($req->ajax()) {
            $data = Places::with('placeCategory')->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn =
                    '<button class="ml-1 mb-1 btn btn-sm btn-primary editPlaceBtn" title="Edit Place"'. 
                    ' data-id="'.$row->id.'"'.
                    ' data-place_category_id="'.$row->place_category_id.'"'.
                    ' data-place_name="'.$row->place_name.'"'.
                    ' data-toggle="modal"'.
                    ' data-target="#editPlaceModal"'.                   
                        '><i class="fa fa-pen"></i></button>'.
                    '<button class="ml-1 mb-1 btn btn-sm btn-danger" title="Delete Place" onClick="deletePlace('.$row->id.')"'.
                        '><i class="fa fa-trash"></i></button>'
                    ;
                    return $actionBtn;
                })
                ->addColumn('qrcode', function ($row) {
                  $qr = QrCode::size(100)
                  ->generate(url('/menu?token='.$row->place_token));
          
                  return '<div class="qr-wrapper" id="qr-'.$row->id.'">
                              '.$qr.'
                          </div>
                          <button class="btn btn-sm btn-primary mt-2" onclick="printQRCode('.$row->id.')">
                              Cetak QR
                          </button>'; 
                })
                ->rawColumns(['action','qrcode'])
                ->make(true);
          }
    }

    public function store(Request $request)
    {
      $res['error']=false;
      $res['message']="";
      $res['data']='';
      try {
        $data = new Places();  
        $data->place_category_id = $request->place_category_id;
        $data->place_name = $request->place_name;
        $data->place_token = Str::uuid()->toString();
        if($data->save()){
          $res['message']="Place saved successfully.";
        }else{
          $res['error']=true;
          $res['message']="Place failed to save!";
        }
      } catch (\Exception $e) {
        $res['error']=true;
        $res['message']=$e->getMessage();
      }
             
      return response()->json($res);
    }

    public function update(Request $request)
    {
      $res['error']=false;
      $res['message']="";
      $res['data']='';

      $data = Places::where('id',$request->id)->first();
      try {
        $data->place_category_id = $request->place_category_id;
        $data->place_name = $request->place_name;
        if($data->save()){
          $res['message']="Place updated successfully.";
        }else{
          $res['error']=true;
          $res['message']="Place failed to update!";
        }
      } catch (\Exception $e) {
        $res['error']=true;
        $res['message']=$e->getMessage();
      }
             
      return response()->json($res);
    }

    public function destroy(Request $request)
    {
      $res['error']=false;
      $res['data']='';
      $res['message']="";
      // delete
      $data = Places::where('id',$request->id)->first();
      if ($data->delete()) {
        $res['message']="Place has been deleted.";
      }else{
        $res['error']=true;
        $res['message']="Fail to delete place!";
      }
      // redirect
      return response()->json($res);
    }
}
