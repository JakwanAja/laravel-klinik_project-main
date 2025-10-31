<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TripleEncryptionService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override method login untuk web
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        
        // Cari user berdasarkan email
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return false;
        }
        
        // Enkripsi password yang diinput dengan 3 layer
        $encryptedPassword = TripleEncryptionService::encrypt($credentials['password']);
        
        // Cek apakah password yang sudah dienkripsi cocok dengan hash di database
        if (Hash::check($encryptedPassword, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            return true;
        }
        
        return false;
    }

    /**
     * Login API
     */
    public function loginApi(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email
        $user = \App\Models\User::where('email', $loginData['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        
        // Enkripsi password yang diinput dengan 3 layer
        $encryptedPassword = TripleEncryptionService::encrypt($loginData['password']);
        
        // Cek apakah password yang sudah dienkripsi cocok dengan hash di database
        if (Hash::check($encryptedPassword, $user->password)) {
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['data' => $user, 'token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}