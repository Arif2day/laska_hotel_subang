<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Orders;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        
        View::composer('*', function ($view) {
            $token = request()->query('token') ?? session('token'); // ambil dari query atau session
            $pendingOrder = null;
            $onProcessOrder = null;
            
            if($token){
                $pendingOrder = Orders::where('place_token', $token)
                                      ->where('status', 'pending')
                                      ->latest()
                                      ->first();
                $onProcessOrder = Orders::where('place_token', $token)
                                ->where('status', 'approved')
                                ->latest()
                                ->first();
                
                                // kalau tidak ada pending/approved -> hapus session token
                if (!$pendingOrder && !$onProcessOrder) {
                    session()->forget('token');
                    $token = null; // biar variabel view juga ikut kosong
                }
            }
            
            $cart = session('cart');
            $view->with(compact('pendingOrder', 'token','onProcessOrder','cart'));
        });

    }
}
