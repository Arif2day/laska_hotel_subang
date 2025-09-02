<?php

namespace App\Http\Controllers\SUPER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlaceCategories;

use Sentinel;
use DataTables;

class PlaceCategoryController extends Controller
{
    public function index() {
        return view('Admin.SUPER.place-category.index');
    }

    public function getPlaceCategoryList(Request $req) {
        if ($req->ajax()) {
            $data = PlaceCategories::all();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn =
                    '<button class="ml-1 mb-1 btn btn-sm btn-primary editPlaceCategoryBtn" title="Edit Place Category"'. 
                    ' data-id="'.$row->id.'"'.
                    ' data-category_name="'.$row->category_name.'"'.
                    ' data-toggle="modal"'.
                    ' data-target="#editPlaceCategoryModal"'.                   
                        '><i class="fa fa-pen"></i></button>'.
                    '<button class="ml-1 mb-1 btn btn-sm btn-danger" title="Delete Place Category" onClick="deletePlaceCategory('.$row->id.')"'.
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
        $data = new PlaceCategories();  
        $data->category_name = $request->category_name;
        if($data->save()){
          $res['message']="Place category saved successfully.";
        }else{
          $res['error']=true;
          $res['message']="Place category failed to save!";
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

      $data = PlaceCategories::where('id',$request->id)->first();
      try {
        $data->category_name = $request->category_name;
        if($data->save()){
          $res['message']="Place category updated successfully.";
        }else{
          $res['error']=true;
          $res['message']="Place category failed to update!";
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
      $data = PlaceCategories::where('id',$request->id)->first();
      if ($data->delete()) {
        $res['message']="Place category has been deleted.";
      }else{
        $res['error']=true;
        $res['message']="Fail to delete place category!";
      }
      // redirect
      return response()->json($res);
    }
}
