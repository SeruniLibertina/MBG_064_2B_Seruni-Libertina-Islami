<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermintaanController; 

// Rute halaman utama
Route::get('/', function () {
    return view('welcome');
});

// --- RUTE UNTUK AUTENTIKASI ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- RUTE UNTUK DASHBOARD (Bisa diakses semua user yang sudah login) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


// --- RUTE UNTUK FITUR PETUGAS GUDANG ---
Route::middleware(['auth', 'role:gudang'])->group(function () {
    Route::get('bahan-baku/{bahanBaku}/confirm-delete', [BahanBakuController::class, 'confirmDelete'])->name('bahan-baku.confirm-delete');
    Route::resource('bahan-baku', BahanBakuController::class);
});

// --- RUTE UNTUK FITUR PETUGAS DAPUR ---
    Route::middleware(['auth', 'role:dapur'])->group(function () {
    Route::get('/permintaan', [PermintaanController::class, 'index'])->name('permintaan.index');

    Route::get('/permintaan/create', [PermintaanController::class, 'create'])->name('permintaan.create');
    Route::post('/permintaan', [PermintaanController::class, 'store'])->name('permintaan.store');
});