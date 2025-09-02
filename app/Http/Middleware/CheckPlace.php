<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Places;

class CheckPlace
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('beranda')
                ->with('error', 'QR-Code tidak ditemukan, silakan scan QR order yang tersedia.');
        }

        $place = Places::where('place_token', $token)->first();

        if (!$place) {
            return redirect()->route('beranda')
                ->with('error', 'QR-Code tidak valid.');
        }

        if ($place->status === 'occupied') {
            return redirect()->route('beranda')
                ->with('error', 'Tempat order ini sedang digunakan.');
        }

        // Lolos validasi
        return $next($request);
    }
}
