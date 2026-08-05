<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Usercontroller;

// Route yang bisa diakses ketika user belum login (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

// Route yang bisa diakses ketika user sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin-only Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [Usercontroller::class, 'index'])->name('users');
        Route::get('/users/create', [Usercontroller::class, 'create'])->name('users.create');
        
        // FIXED: Changed '/users/store' to '/users' so POST /admin/users works
        Route::post('/users', [Usercontroller::class, 'store'])->name('users.store');
        
        Route::get('/users/edit/{user}', [Usercontroller::class, 'edit'])->name('users.edit');
        Route::post('/users/update/{user}', [Usercontroller::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [Usercontroller::class, 'destroy'])->name('users.destroy');
    });

    // Admin & Kasir Shared Routes
    Route::middleware('role:admin,kasir')->group(function () {
        Route::resource('/produk', ProdukController::class);
        Route::resource('/penjualan', PenjualanController::class);
        Route::resource('/itempenjualan', ItemPenjualanController::class);
        Route::get('/admin/penjualan/{penjualan}', [PenjualanController::class, 'show'])
            ->name('admin.penjualan.show');
    });
});