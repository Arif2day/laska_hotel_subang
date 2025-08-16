<?php

namespace App\Http\Controllers\SUPER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuTypes;
use App\Models\Menus;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\File;
use Sentinel;
use DataTables;

class MenuController extends Controller
{
    public function index() {
      $menu_types = MenuTypes::all();
        return view('Admin.SUPER.menu.index',compact(['menu_types']));
    }

    public function getMenuList(Request $req) {
        if ($req->ajax()) {
            $data = Menus::with('menuType')->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn =
                    '<button class="ml-1 mb-1 btn btn-sm btn-primary editMenuBtn" title="Edit Menu"'. 
                    ' data-id="'.$row->id.'"'.
                    ' data-menu_type_id="'.$row->menu_type_id.'"'.
                    ' data-menu_name="'.$row->menu_name.'"'.
                    ' data-description="'.$row->description.'"'.
                    ' data-ingredients="'.$row->ingredients.'"'.
                    ' data-picture_path="'.asset($row->picture_path).'"'.
                    ' data-status="'.$row->status.'"'.
                    ' data-price="'.$row->price.'"'.
                    ' data-toggle="modal"'.
                    ' data-target="#editMenuModal"'.                   
                        '><i class="fa fa-pen"></i></button>'.
                    '<button class="ml-1 mb-1 btn btn-sm btn-danger" title="Delete Menu" onClick="deleteMenu('.$row->id.')"'.
                        '><i class="fa fa-trash"></i></button>'
                    ;
                    return $actionBtn;
                  })
                ->addColumn('thumbnail', function ($row) {
                      $url = asset($row->picture_path);
                      return '<img src="'.$url.'" alt="'.$row->name.'" width="50" height="50" style="object-fit:cover;border-radius:5px;">';
                  })
                ->editColumn('price', function($row) {
                    return number_format($row->price, 0, ',', '.');
                  })
                ->rawColumns(['action','thumbnail'])
                ->make(true);
          }
    }

    public function store(Request $request)
    {
      $res['error']=false;
      $res['message']="";
      $res['data']='';
      try {
        $data = new Menus();  
        
        $imageData = (object)[
          'path' => 'menus/',
          'uniqid' => "menus",
          'image' => $request->picture,
        ];
        $picPath = ImageHelper::uploadImage($imageData);
        
        $data->menu_type_id = $request->menu_type_id;
        $data->menu_name = $request->menu_name;
        $data->description = $request->description;
        $data->ingredients = $request->ingredients;
        $data->picture_path = $picPath;
        $data->status = $request->status;
        $data->price = $request->price;
        if($data->save()){
          $res['message']="Menu saved successfully.";
        }else{
          $res['error']=true;
          $res['message']="Menu failed to save!";
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

      $data = Menus::where('id',$request->id)->first();
      try {
        if (!empty($request->picture)) {

          // cek apakah menu lama punya gambar
          if (!empty($data->picture_path)) {
              $oldFile = public_path($data->picture_path);
              if (File::exists($oldFile)) {
                  File::delete($oldFile);
              }
          }
          $imageData = (object)[
            'path' => 'menus/',
            'uniqid' => "menus",
            'image' => $request->picture,
          ];
          $picPath = ImageHelper::uploadImage($imageData);
          $data->picture_path = $picPath;
        }
        

        $data->menu_type_id = $request->menu_type_id;
        $data->menu_name = $request->menu_name;
        $data->description = $request->description;
        $data->ingredients = $request->ingredients;
        $data->status = $request->status;
        $data->price = $request->price;
        if($data->save()){
          $res['message']="Menu updated successfully.";
        }else{
          $res['error']=true;
          $res['message']="Menu failed to update!";
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
      $data = Menus::where('id',$request->id)->first();
      
      $path = public_path($data->picture_path);
      
      if (File::exists($path)) {
          File::delete($path);
      }
    
      if ($data->delete()) {
        $res['message']="Menu has been deleted.";
      }else{
        $res['error']=true;
        $res['message']="Fail to delete menu!";
      }
      // redirect
      return response()->json($res);
    }
}
