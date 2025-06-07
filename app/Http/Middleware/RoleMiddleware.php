<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika pengguna tidak login atau tidak memiliki peran, tolak akses.
        if (!Auth::check() || !Auth::user()->role) {
            abort(403, 'AKSES DITOLAK');
        }

        // Ambil nama peran dari pengguna yang sedang login.
        $userRole = Auth::user()->role->name;

        // Periksa apakah peran pengguna ada di dalam daftar peran yang diizinkan.
        if (in_array($userRole, $roles)) {
            // Jika diizinkan, lanjutkan request ke tujuan berikutnya.
            return $next($request);
        }

        // Jika peran tidak cocok, tolak akses.
        abort(403, 'ANDA TIDAK MEMILIKI HAK AKSES UNTUK HALAMAN INI.');
    }
}
