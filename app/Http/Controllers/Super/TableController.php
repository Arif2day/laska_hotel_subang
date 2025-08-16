<?php

namespace App\Http\Controllers\SUPER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TableClasses;
use App\Models\Tables;

use Sentinel;
use DataTables;

class TableController extends Controller
{
    public function index() {
      $table_classes = TableClasses::all();
        return view('Admin.SUPER.table.index',compact(['table_classes']));
    }

    public function getTableList(Request $req) {
        if ($req->ajax()) {
            $data = Tables::with('tableClass')->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn =
                    '<button class="ml-1 mb-1 btn btn-sm btn-primary editTableBtn" title="Edit Table"'. 
                    ' data-id="'.$row->id.'"'.
                    ' data-table_class_id="'.$row->table_class_id.'"'.
                    ' data-table_name="'.$row->table_name.'"'.
                    ' data-toggle="modal"'.
                    ' data-target="#editTableModal"'.                   
                        '><i class="fa fa-pen"></i></button>'.
                    '<button class="ml-1 mb-1 btn btn-sm btn-danger" title="Delete Table" onClick="deleteTable('.$row->id.')"'.
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
        $data = new Tables();  
        $data->table_class_id = $request->table_class_id;
        $data->table_name = $request->table_name;
        if($data->save()){
          $res['message']="Table saved successfully.";
        }else{
          $res['error']=true;
          $res['message']="Table failed to save!";
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

      $data = Tables::where('id',$request->id)->first();
      try {
        $data->table_class_id = $request->table_class_id;
        $data->table_name = $request->table_name;
        if($data->save()){
          $res['message']="Table updated successfully.";
        }else{
          $res['error']=true;
          $res['message']="Table failed to update!";
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
      $data = Tables::where('id',$request->id)->first();
      if ($data->delete()) {
        $res['message']="Table has been deleted.";
      }else{
        $res['error']=true;
        $res['message']="Fail to delete table!";
      }
      // redirect
      return response()->json($res);
    }
}
