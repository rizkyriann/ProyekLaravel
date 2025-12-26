<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi karyawan baru.
     */
    public function showForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    /**
     * Proses registrasi user + profil employee.
     */
    public function store(RegisterRequest $userRequest, EmployeeRequest $employeeRequest)
    {
        // Validasi input
        $userData = $userRequest->validated();
        $employeeData = $employeeRequest->validated();

        // Buat user baru
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'role' => $userData['role'],
            'status' => $userData['status'],
        ]);

        // Upload file jika ada
        if (isset($employeeData['photo'])) {
            $employeeData['photo'] = $employeeRequest->file('photo')->store('photos', 'public');
        }

        if (isset($employeeData['ktp_document'])) {
            $employeeData['ktp_document'] = $employeeRequest->file('ktp_document')->store('ktp', 'public');
        }

        // Buat profil employee
        $user->employee()->create([
            'nama_lengkap' => $employeeData['nama_lengkap'],
            'jenis_kelamin' => $employeeData['jenis_kelamin'],
            'alamat' => $employeeData['alamat'] ?? null,
            'no_telp' => $employeeData['no_telp'],
            'pendidikan_terakhir' => $employeeData['pendidikan_terakhir'],
            'jabatan' => $employeeData['jabatan'] ?? null,
            'photo' => $employeeData['photo'],
            'ktp_document' => $employeeData['ktp_document'],
        ]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dibuat.');
    }
}
