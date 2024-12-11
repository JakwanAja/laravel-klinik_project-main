<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LaporanPasienController;
use App\Http\Controllers\LaporanDaftarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to home
Route::get('/', function () {
    return redirect('/dashboard');
});

// Routes requiring authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');
    
    // Profile
    Route::view('profile', 'profile')
        ->name('profile');

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Resources
    Route::resource('pasien', PasienController::class);
    Route::resource('daftar', DaftarController::class);
    Route::resource('laporan-pasien', LaporanPasienController::class);
    Route::resource('laporan-daftar', LaporanDaftarController::class);

    // Additional routes
    Route::get('/pasien/{id}', [PasienController::class, 'show'])->name('pasien.show');
    Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');
});

// Authentication routes (login, register, logout, etc.)
Auth::routes(['verify' => true]);

// Custom logout route
Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
});

// Include Laravel Breeze auth routes if applicable
require __DIR__ . '/auth.php';
