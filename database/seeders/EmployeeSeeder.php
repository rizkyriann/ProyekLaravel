<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $admin      = User::where('role', 'admin')->first();
        $karyawan   = User::where('role', 'karyawan')->first();

        if ($superadmin) {
            Employee::create([
                'user_id'       => $superadmin->id,
                'nama_lengkap'  => 'Super Admin',
                'jenis_kelamin' => 'Laki-Laki',
                'alamat'        => 'Jl. Merdeka No.1',
                'no_telp'       => '081234567890',
                'pendidikan_terakhir' => 'S1 Teknik Informatika',
                'jabatan'       => 'Direktur',
                'photo'         => null,
                'ktp_document'  => null,
            ]);
        }

        if ($admin) {
            Employee::create([
                'user_id'       => $admin->id,
                'jabatan'       => 'Admin Proyek',
                'photo'         => null,
                'ktp_document'  => null,
            ]);
        }

        if ($karyawan) {
            Employee::create([
                'user_id'       => $karyawan->id,
                'jabatan'       => 'Karyawan Lapangan',
                'photo'         => null,
                'ktp_document'  => null,
            ]);
        }
    }
}
