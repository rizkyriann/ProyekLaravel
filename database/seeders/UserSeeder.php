<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@example.com',
            'password' => Hash::make('123456'),
            'role'     => 'superadmin',
            'status'   => true,
        ]);

        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role'     => 'admin',
            'status'   => true,
        ]);

        User::create([
            'name'     => 'Karyawan',
            'email'    => 'karyawan@example.com',
            'password' => Hash::make('password'),
            'role'     => 'karyawan',
            'status'   => true,
        ]);
    }
}
