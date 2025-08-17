<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use iio\libmergepdf\Merger;
use App\Models\Users;
use App\Models\Menus;
use App\Models\Tables;
use App\Models\Orders;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {        
        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong.');
        }

        DB::beginTransaction();
        try {
            // Simpan ke tabel orders
            $table = Tables::where('table_token',$request->token)->first();
            if($table->status=="available")
            {

                $order = Orders::create([
                    'table_id'     => $table->id,   // bisa juga ambil dari token meja
                    'table_token'        => $request->token,
                    'reservator_name'        => $request->reservator_name,
                    'total_amount' => collect($cart)->sum(function ($item) {
                        return $item['price'] * $item['qty'];
                    }),
                    'payment_status'=>'unpaid',
                    'payment_method'=>'cash',
                    'status'       => 'pending',
                ]);
    
                // Simpan ke tabel order_items
                foreach ($cart as $productId => $item) {
                    OrderDetails::create([
                        'order_id'   => $order->id,
                        'menu_id' => $productId,
                        'quantity'        => $item['qty'],
                        'price'      => $item['price'],
                        'subtotal'   => $item['price'] * $item['qty'],
                        'note'        =>$item['note']
                    ]);
                }
                $table->status="occupied";
                $table->save();
                DB::commit();
    
                session(['pending_order_id' => $order->id, 'token' => $request->token]);
                // Hapus session cart
                session()->forget('cart');
    
                return response()->json([
                    'success' => true,
                    'message' => 'Order berhasil dibuat',
                    'order_id' => $order->id
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Meja sedang digunakan',
                ]);
            }
            // return redirect()->route('payment.show', $order->id)
            //                  ->with('success', 'Pesanan berhasil dibuat, lanjutkan ke pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}
