<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use iio\libmergepdf\Merger;
use App\Models\Users;
use App\Models\Menus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CartController extends Controller
{
    public function add(Request $req) {
        $cart = session()->get('cart', []);
        $id = $req->id;
        if (isset($cart[$id])) $cart[$id]['qty'] += $req->qty;
        else $cart[$id] = [
            'name' => $req->name,
            'price' => $req->price,
            'qty' => $req->qty,
            'note' => $req->note ?? '',
        ];
        session(['cart' => $cart]);
        return response()->json(['success' => true]);
    }

    public function delete(Request $req) {
        $cart = session()->get('cart', []);
        unset($cart[$req->id]);
        session()->put('cart', $cart);
        return back();
    }

    public function updateNote(Request $request)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->id])) {
            $cart[$request->id]['note'] = $request->note;
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }

    public function view() {
        return view('Guest.menu.partials.cart');
    }
}
