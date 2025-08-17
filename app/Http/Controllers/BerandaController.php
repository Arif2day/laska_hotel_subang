<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use iio\libmergepdf\Merger;
use App\Models\Users;
use App\Models\Menus;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class BerandaController extends Controller
{
    public function index(Request $request) {           
        $return = array();
        return view("Guest.beranda.index", compact([]));
    }

    public function indexMenu() {           
        $menus = Menus::all();
        return view("Guest.menu.index", compact(['menus']));
    }
}
