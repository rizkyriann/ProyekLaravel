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
                'photo'         => 'dummy/photo.jpg',
                'ktp_document'  => 'dummy/ktpphoto.jpg',
            ]);
        }

        if ($admin) {
            Employee::create([
                'user_id'       => $admin->id,
                'jabatan'       => 'Admin Proyek',
                'jenis_kelamin' => 'Perempuan',
                'nama_lengkap'  => 'Admin User',
                'alamat'        => 'Jl. Sudirman No.10',
                'no_telp'       => '089876543210',
                'pendidikan_terakhir' => 'S1 Manajemen',
                'photo'         => 'dummy/photo.jpg',
                'ktp_document'  => 'dummy/ktpphoto.jpg',
            ]);
        }

        if ($karyawan) {
            Employee::create([
                'user_id'       => $karyawan->id,
                'jabatan'       => 'Karyawan Lapangan',
                'jenis_kelamin' => 'Laki-Laki',
                'nama_lengkap'  => 'Karyawan Lapangan',
                'alamat'        => 'Jl. Karyawan No.1',
                'no_telp'       => '081234567890',
                'pendidikan_terakhir' => 'S1 Teknik Informatika',
                'photo'         => 'dummy/photo.jpg',
                'ktp_document'  => 'dummy/ktpphoto.jpg',
            ]);
        }
    }
}
