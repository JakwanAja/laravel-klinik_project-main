<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LaporanPasienController;
use App\Http\Controllers\LaporanDaftarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/home');
});
//Route untuk mengamankan PasienController (untuk mengaksesnya harus Login dulu!!)
Route::middleware(['auth'])->group(function () {
    Route::resource('pasien', PasienController::class);
    Route::resource('daftar', DaftarController::class);
    Route::resource('laporan-pasien', LaporanPasienController::class);
    Route::resource('laporan-daftar', LaporanDaftarController::class);

    Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
});


// Authentication routes (login, register, logout, etc.)
Auth::routes();

Route::get('logout', function(){
    Auth::logout();
    return redirect('login');
});

Auth::routes(['verify' => true]);
