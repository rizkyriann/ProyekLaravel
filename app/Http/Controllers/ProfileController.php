<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil user saat ini.
     */
    public function show()
    {
        $user = Auth::user();
        $user->load('employee'); // load relasi employee
        return view('profile.show', compact('user'));
    }

    /**
     * Update profil user saat ini.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'jabatan' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'ktp_document' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
        ]);

        // Update user
        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update employee profile
        $employeeData = [];
        if ($request->has('jabatan')) $employeeData['jabatan'] = $request->jabatan;
        if ($request->hasFile('photo')) {
            $employeeData['photo'] = $request->file('photo')->store('photos', 'public');
        }
        if ($request->hasFile('ktp_document')) {
            $employeeData['ktp_document'] = $request->file('ktp_document')->store('ktp', 'public');
        }

        $user->employee()->update($employeeData);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
