<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * List semua karyawan
     */
    public function index()
    {
        $employees = Employee::with('user')->latest()->get();
        return view('pages.employees.index', compact('employees'));
    }

    /**
     * Form tambah karyawan
     */
    public function create()
    {
        return view('pages.employees.create');
    }

    /**
     * Simpan karyawan + akun user
     */
    public function store(Request $request)
    {
        $request->validate([
            // user
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:superadmin,admin,karyawan',

            // employee
            'jabatan'      => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required|string|max:500',
            'no_telp' => 'required|string|max:20',
            'pendidikan_terakhir' => 'required|string|max:100',
            'photo'        => 'required|image|max:2048',
            'ktp_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::transaction(function () use ($request) {

            //Buat user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
                'status'   => true,
            ]);

            //Upload file
            $photoPath = $request->file('photo')
                ? $request->file('photo')->store('employees/photos', 'public')
                : null;

            $ktpPath = $request->file('ktp_document')
                ? $request->file('ktp_document')->store('employees/ktp', 'public')
                : null;

            //Buat employee
            Employee::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'       => $request->alamat,
                'no_telp'      => $request->no_telp,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'jabatan'      => $request->jabatan,
                'photo'        => $photoPath,
                'ktp_document' => $ktpPath,
            ]);
        });

        return redirect()->route('admin.dashboard')
            ->with('success', 'Karyawan berhasil ditambahkan');
    }

    /**
     * Detail karyawan
     */
    public function show(Employee $employee)
    {
        $employee->load('user');
        return view('pages.employees.show', compact('employee'));
    }

    /**
     * Form edit karyawan
     */
    public function edit(Employee $employee)
    {
        $employee->load('user');
        return view('pages.employees.edit', compact('employee'));
    }

    /**
     * Update karyawan + user
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $employee->user_id,
            'role'     => 'required|in:superadmin,admin,karyawan',
            'status'   => 'required|boolean',

            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat'       => 'nullable|string|max:500',
            'no_telp'      => 'required|string|max:20',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jabatan'      => 'required|string|max:255',
            'photo'        => 'nullable|image|max:2048',
            'ktp_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::transaction(function () use ($request, $employee) {

            // update user
            $employee->user->update([
                'name'   => $request->name,
                'email'  => $request->email,
                'role'   => $request->role,
                'status' => $request->status,
            ]);

            // upload ulang file
            if ($request->hasFile('photo')) {
                if ($employee->photo) {
                    Storage::disk('public')->delete($employee->photo);
                }
                $employee->photo = $request->file('photo')
                    ->store('employees/photos', 'public');
            }

            if ($request->hasFile('ktp_document')) {
                if ($employee->ktp_document) {
                    Storage::disk('public')->delete($employee->ktp_document);
                }
                $employee->ktp_document = $request->file('ktp_document')
                    ->store('employees/ktp', 'public');
            }

            // update employee
            $employee->update([
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'       => $request->alamat,
                'no_telp'      => $request->no_telp,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,

                'jabatan'      => $request->jabatan,
                'photo'        => $employee->photo,
                'ktp_document' => $employee->ktp_document,
            ]);
        });

        return redirect()->back()
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    /**
     * Nonaktifkan akun (soft delete versi bisnis)
     */
    public function deactivate(Employee $employee)
    {
        $employee->user->update([
            'status' => false,
        ]);

        return back()->with('success', 'Akun karyawan dinonaktifkan');
    }

    /**
     * Aktifkan akun kembali
     */
    public function activate(Employee $employee)
    {
        $employee->user->update([
            'status' => true,
        ]);

        return back()->with('success', 'Akun karyawan diaktifkan');
    }
}
