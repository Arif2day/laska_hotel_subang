<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use iio\libmergepdf\Merger;
use App\Models\Users;
use App\Models\Menus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ScanController extends Controller
{
    public function index()
    {
        return view('Guest.scan.index');
    }
}
