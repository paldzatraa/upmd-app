<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Logika: Jika user bukan admin, tendang ke dashboard
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini khusus Admin.');
        }

        return $next($request);
    }
}