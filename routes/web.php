<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rute halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk menampilkan form login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Rute untuk memproses data dari form login
Route::post('/login', [AuthController::class, 'login']);
// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    // Rute sementara untuk halaman bahan baku
    Route::get('/bahan-baku', function () {
        // Cek role untuk keamanan tambahan
        if (auth()->user()->role !== 'gudang') {
            abort(403); // Akses ditolak jika bukan gudang
        }
        return '<h1>Selamat Datang di Halaman Bahan Baku</h1><p>Login Anda sebagai Petugas Gudang Berhasil!</p>';
    });

});