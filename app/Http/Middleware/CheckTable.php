<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tables;

class CheckTable
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
                ->with('error', 'QR-Code tidak ditemukan, silakan scan QR dari meja.');
        }

        $table = Tables::where('table_token', $token)->first();

        if (!$table) {
            return redirect()->route('beranda')
                ->with('error', 'QR-Code tidak valid.');
        }

        if ($table->status === 'occupied') {
            return redirect()->route('beranda')
                ->with('error', 'Meja ini sedang digunakan.');
        }

        // Lolos validasi
        return $next($request);
    }
}
