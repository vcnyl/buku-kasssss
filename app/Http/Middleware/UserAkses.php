<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Periksa apakah role pengguna yang sedang login cocok dengan role yang diterima
        if(auth()->check() && auth()->user()->role == $role){
            return $next($request);
        }
        
        // Jika role tidak cocok, tampilkan respon tidak diizinkan
        return response()->json(['message' => 'Tidak boleh mengakses halaman ini'], 403);
    }
}
