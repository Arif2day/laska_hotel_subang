<?php

namespace App\Http\Controllers\SUPER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TableClasses;

use Sentinel;
use DataTables;

class TableClassController extends Controller
{
    public function index() {
        return view('Admin.SUPER.table-class.index');
    }

    public function getTableClassList(Request $req) {
        if ($req->ajax()) {
            $data = TableClasses::all();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn =
                    '<button class="ml-1 mb-1 btn btn-sm btn-primary editTableClassBtn" title="Edit Table Class"'. 
                    ' data-id="'.$row->id.'"'.
                    ' data-class_name="'.$row->class_name.'"'.
                    ' data-toggle="modal"'.
                    ' data-target="#editTableClassModal"'.                   
                        '><i class="fa fa-pen"></i></button>'.
                    '<button class="ml-1 mb-1 btn btn-sm btn-danger" title="Delete Table Class" onClick="deleteTableClass('.$row->id.')"'.
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
        $data = new TableClasses();  
        $data->class_name = $request->class_name;
        if($data->save()){
          $res['message']="Table class saved successfully.";
        }else{
          $res['error']=true;
          $res['message']="Table class failed to save!";
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

      $data = TableClasses::where('id',$request->id)->first();
      try {
        $data->class_name = $request->class_name;
        if($data->save()){
          $res['message']="Table class updated successfully.";
        }else{
          $res['error']=true;
          $res['message']="Table class failed to update!";
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
      $data = TableClasses::where('id',$request->id)->first();
      if ($data->delete()) {
        $res['message']="Table class has been deleted.";
      }else{
        $res['error']=true;
        $res['message']="Fail to delete table class!";
      }
      // redirect
      return response()->json($res);
    }
}
