<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KaryawanMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'karyawan') {
            // Jika bukan karyawan, redirect ke dashboard admin
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman karyawan');
        }

        return $next($request);
    }
}
