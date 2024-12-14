<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LaporanPasienController;
use App\Http\Controllers\LaporanDaftarController;
use App\Http\Controllers\PoliController;


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

    // Resources (Memuat semua view dari controller)
    Route::resource('pasien', PasienController::class);
    Route::resource('daftar', DaftarController::class);
    Route::resource('laporan-pasien', LaporanPasienController::class);
    Route::resource('laporan-daftar', LaporanDaftarController::class);
    Route::resource('polis', PoliController::class);

    // Routes Tambahan
    Route::get('/pasien/{id}', [PasienController::class, 'show'])->name('pasien.show');
    Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');
});

// Authentication routes (login, register, logout, etc.)
Auth::routes(['verify' => true]);

//Make Admin
Route::get('/make-admin', [PasienController::class, 'makeAdmin']);

Route::middleware('role:admin')->get('/daftar', [DaftarController::class, 'index']);
Route::middleware('role:admin')->group(function() {
    Route::get('/laporan-daftar/create', [LaporanDaftarController::class, 'create'])->name('laporan-daftar.create');
    Route::get('/laporan-daftar', [LaporanDaftarController::class, 'index'])->name('laporan-daftar.index');
});
Route::middleware('role:admin')->group(function() {
    Route::get('/laporan-pasien/create', [LaporanPasienController::class, 'create'])->name('laporan-daftar.create');
    Route::get('/laporan-pasien', [LaporanPasienController::class, 'index'])->name('laporan-daftar.index');
});

// Custom logout route
Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
});

// Login Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


require __DIR__ . '/auth.php';
