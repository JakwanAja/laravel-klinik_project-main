<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\Auth\LoginController;

// Route untuk login
Route::post('login', [LoginController::class, 'loginApi']);

// Route untuk pengguna yang sudah login (autentikasi)
Route::middleware('auth:sanctum')->group(function () {
    // Ambil data pengguna yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Proteksi semua route pasien dengan sanctum
    Route::patch('pasien/restore/{id}', [PasienController::class, 'restore']);

    Route::resource('pasien', PasienController::class);
});


