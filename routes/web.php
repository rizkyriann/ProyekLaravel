<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HandoverController;

Route::get('/', function () {
    return view('welcome');
});


//Login dan logout, tanpa middleware
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

//Redirect dashboard berdasarkan role
Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    return match ($role) {
        'superadmin' => redirect()->route('superadmin.dashboard'),
        'admin'      => redirect()->route('admin.dashboard'),
        'karyawan'   => redirect()->route('karyawan.dashboard'),
        default      => abort(403),
    };
})->middleware('auth');

Route::middleware(['auth', 'role:admin,superadmin'])
    ->prefix('warehouse')
    ->name('warehouse.')
    ->group(function () {

        //ROUTE INDEX GUDANG
        Route::resource('items', ItemController::class)
            ->only(['index', 'show']);
        Route::get('items/{item}/stock-card', [ItemController::class, 'stockCard'])
            ->name('items.stock-card');

        //ROUTE INVOICE
        Route::get('invoices', [InvoiceController::class, 'index'])
            ->name('invoices.index');

        Route::get('invoices/create', [InvoiceController::class, 'create'])
            ->name('invoices.create');

        Route::post('invoices', [InvoiceController::class, 'store'])
            ->name('invoices.store');

        Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])
            ->name('invoices.show');

        Route::patch('invoices/{invoice}/cancel', [InvoiceController::class, 'cancel'])
            ->name('invoices.cancel');

        Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])
            ->name('invoices.destroy');

        //ROUTE HANDOVER
        Route::get('handovers', [HandoverController::class, 'index'])
            ->name('handovers.index');

        Route::get('handovers/create', [HandoverController::class, 'create'])
            ->name('handovers.create');

        Route::post('handovers', [HandoverController::class, 'store'])
            ->name('handovers.store');

        Route::get('handovers/{handover}', [HandoverController::class, 'show'])
            ->name('handovers.show');

        Route::get('handovers/{handover}/edit', [HandoverController::class, 'edit'])
            ->name('handovers.edit');

        Route::put('handovers/{handover}', [HandoverController::class, 'update'])
            ->name('handovers.update');

        Route::delete('handovers/{handover}', [HandoverController::class, 'destroy'])
            ->name('handovers.destroy');

        Route::get('/warehouse/check-sku', function (Request $request) {
            return response()->json([
                'exists' => \App\Models\Item::where('sku', $request->sku)->exists()
            ]);
        })->name('warehouse.check-sku');

        Route::post('{handover}/confirm', [HandoverController::class, 'confirm'])
            ->name('handovers.confirm');

        Route::post('{handover}/cancel', [HandoverController::class, 'cancel'])
            ->name('handovers.cancel');
    });


//Superadmin Route
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.dashboard.superadmin.index');
        })->name('dashboard');

    });


//Admin Route
Route::middleware(['auth', 'role:admin,superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.dashboard.admin.index');
        })->name('dashboard');

        //Manajemen Karyawan
        Route::resource('employees', EmployeeController::class);
        Route::post('employees/{employee}/deactivate', [EmployeeController::class, 'deactivate'])->name('employees.deactivate');
        Route::post('employees/{employee}/activate', [EmployeeController::class, 'activate'])->name('employees.activate');
    });


//Karyawan Route
Route::middleware(['auth', 'role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.dashboard.karyawan.index');
        })->name('dashboard');
    });


//Route semua role
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
