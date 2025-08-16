<?php

namespace App\Http\Controllers\SUPER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuTypes;

use Sentinel;
use DataTables;

class MenuTypeController extends Controller
{
    public function index() {
        return view('Admin.SUPER.menu-type.index');
    }

    public function getMenuTypeList(Request $req) {
        if ($req->ajax()) {
            $data = MenuTypes::all();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn =
                    '<button class="ml-1 mb-1 btn btn-sm btn-primary editMenuTypeBtn" title="Edit Menu type"'. 
                    ' data-id="'.$row->id.'"'.
                    ' data-type="'.$row->type.'"'.
                    ' data-toggle="modal"'.
                    ' data-target="#editMenuTypeModal"'.                   
                        '><i class="fa fa-pen"></i></button>'.
                    '<button class="ml-1 mb-1 btn btn-sm btn-danger" title="Delete Menu type" onClick="deleteMenuType('.$row->id.')"'.
                        '><i class="fa fa-trash"></i></button>'
                    ;
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
          }
    }

    public function store(Request $request)
    {
      $res['error']=false;
      $res['message']="";
      $res['data']='';
      try {
        $data = new MenuTypes();  
        $data->type = $request->type;
        if($data->save()){
          $res['message']="Menu type saved successfully.";
        }else{
          $res['error']=true;
          $res['message']="Menu type failed to save!";
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

      $data = MenuTypes::where('id',$request->id)->first();
      try {
        $data->type = $request->type;
        if($data->save()){
          $res['message']="Menu type updated successfully.";
        }else{
          $res['error']=true;
          $res['message']="Menu type failed to update!";
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
      $data = MenuTypes::where('id',$request->id)->first();
      if ($data->delete()) {
        $res['message']="Menu type has been deleted.";
      }else{
        $res['error']=true;
        $res['message']="Fail to delete menu type!";
      }
      // redirect
      return response()->json($res);
    }
}
