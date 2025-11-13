<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Route;

// Halaman login akan menjadi halaman utama jika belum login
Route::get('/', function () {
    return view('auth.login');
});

// Rute-rute ini hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/details/{pelanggan}', [PelangganController::class, 'show'])->name('pelanggan.show');

    // User / Karyawan
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';