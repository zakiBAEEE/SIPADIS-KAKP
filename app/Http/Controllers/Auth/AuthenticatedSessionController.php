<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

   
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentikasi dahulu
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->is_active || ($user->timKerja && !$user->timKerja->is_active)) {
            Auth::logout(); // penting! agar tidak lanjut login
            return redirect()->route('login')->withErrors([
                'username' => 'Akun Anda atau tim kerja Anda telah dinonaktifkan.',
            ]);
        }

        $role = $user->role->name ?? null;

        return redirect()->route('dashboard');
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
