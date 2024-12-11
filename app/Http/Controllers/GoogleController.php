<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle() 
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            } else {
                // Jika pengguna tidak ditemukan, buat pengguna baru
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email, // pastikan email disimpan
                    'google_id' => $user->id,
                    'password' => Hash::make('password') // atau gunakan password random
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['login_error' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }
}
