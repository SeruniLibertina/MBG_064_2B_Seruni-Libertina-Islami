<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\AuthController;

// Rute halaman utama
Route::get('/', function () {
    return view('welcome');
});

// --- RUTE UNTUK AUTENTIKASI ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- RUTE UNTUK FITUR PETUGAS GUDANG ---
// Grup rute ini hanya bisa diakses oleh user yang sudah login DAN memiliki role 'gudang'
Route::middleware(['auth', 'role:gudang'])->group(function () {
    
    // Rute khusus untuk menampilkan halaman konfirmasi sebelum menghapus
    Route::get('bahan-baku/{bahanBaku}/confirm-delete', [BahanBakuController::class, 'confirmDelete'])->name('bahan-baku.confirm-delete');
    
    Route::resource('bahan-baku', BahanBakuController::class);
    // - bahan-baku.index   (Lihat semua data)
    // - bahan-baku.create  (Tampilkan form tambah)
    // - bahan-baku.store   (Simpan data baru)
    // - bahan-baku.edit    (Tampilkan form edit)
    // - bahan-baku.update  (Update data)
    // - bahan-baku.destroy (Hapus data)
});