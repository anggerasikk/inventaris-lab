<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- BARIS WAJIB DITAMBAHKAN/DIPERBAIKI DI SINI

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Baris 13 (atau baris tempat Auth::check() berada)
        if (Auth::check() && optional(Auth::user())->isAdmin()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}