<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Pastikan menambahkan ini

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function loginApi(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email dan password
        $user = \App\Models\User::where('email', $loginData['email'])->first();

        if ($user && Hash::check($loginData['password'], $user->password)) {
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['data' => $user, 'token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

}
