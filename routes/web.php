<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;


//Login dan logout, tanpa middleware
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

//Redirect dashboard berdasarkan role
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'superadmin' => redirect()->route('superadmin.dashboard'),
        'admin'      => redirect()->route('admin.dashboard'),
        'karyawan'   => redirect()->route('karyawan.dashboard'),
        default      => abort(403),
    };
})->middleware('auth');


//Superadmin Route
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard.superadmin');
        })->name('dashboard');

        // user & employee management (nanti)
    });


//Admin Route
Route::middleware(['auth', 'role:admin,superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard.admin');
        })->name('dashboard');

        // CRUD karyawan (nanti)
    });


//Karyawan Route
Route::middleware(['auth', 'role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard.karyawan');
        })->name('dashboard');
    });


//Route semua role
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
