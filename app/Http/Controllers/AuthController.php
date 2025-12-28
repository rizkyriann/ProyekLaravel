<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('pages.auth.signin'); // pastikan ada resources/views/auth/login.blade.php
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validated([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => 1,
        ])) {
            return back()->withErrors([
                'email' => 'Email atau password salah, atau akun tidak aktif.',
            ])->withInput();
        }

        $request->session()->regenerate();

        $user = Auth::user();

        return match ($user->role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'admin'      => redirect()->route('admin.dashboard'),
            'karyawan'   => redirect()->route('karyawan.dashboard'),
            default      => abort(403),
        };
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
