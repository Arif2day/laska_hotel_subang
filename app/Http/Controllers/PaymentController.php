<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use iio\libmergepdf\Merger;
use App\Models\Users;
use App\Models\Menus;
use App\Models\Orders;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class PaymentController extends Controller
{
   // Menampilkan halaman pembayaran
   public function show(Orders $order,Request $request)
   {
       $order->load('details.menu'); // pastikan relasi dibuat
       return view('Guest.payment.show', compact('order'));
   }

   // Update status menjadi paid
   public function pay(Orders $order)
   {
       $order->update([
           'payment_status' => 'paid',
           'status' => 'approved'
       ]);

       return redirect()->route('payment.show', $order)
                        ->with('success', 'Pembayaran berhasil ditandai lunas.');
   }
}
