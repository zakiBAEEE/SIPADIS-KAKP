<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekStatusAktif
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && (!$user->is_active || ($user->divisi && !$user->divisi->is_active))) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'username' => 'Akun atau divisi Anda telah dinonaktifkan.',
            ]);
        }

        return $next($request);
    }
}