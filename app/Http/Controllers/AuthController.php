<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login'); // pastikan ada resources/views/auth/login.blade.php
    }

    /**
     * Proses login.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Cek login
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'status' => 1])) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->isSuperAdmin()) {
                return redirect()->route('dashboard.superadmin');
            } elseif ($user->isAdmin()) {
                return redirect()->route('dashboard.admin');
            } else {
                return redirect()->route('dashboard.karyawan');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun tidak aktif.',
        ])->withInput();
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
