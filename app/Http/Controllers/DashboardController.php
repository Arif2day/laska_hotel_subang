<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Menus;
use App\Models\Tables;
use App\Models\Orders;
use App\Helpers\customFormat;
use App\Helpers\Dashboard\SADashboard;

use Sentinel;
use Illuminate\Support\Arr;
use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
      $return = array();
      
      $return['menus'] = Menus::all()->count();
      $return['tables'] = Tables::all()->count();
      $return['available_tables']=Tables::where('status','available')->count();      
      $return['order_lives']=Orders::where('status','pending')->orWhere('status','approved')->count();
      $return['approved_order_lives']=Orders::where('status','approved')->count();
      // $return['own_unit_count'] = $this->getDataWithClose56(Users::with(['latestPlacement.getUnit'])->where('id',$us->id)->first()->latestPlacement->unit_id);
      // $return['user_unit'] = 
      return view("Admin.dashboard", $return);
    }




}
