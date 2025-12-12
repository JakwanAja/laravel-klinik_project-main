<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Services\TripleEncryptionService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';
    protected $maxAttempts = 5; // Maksimal 5 percobaan
    protected $decayMinutes = 5; // Blokir 5 menit

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override showLoginForm untuk cek blokir
     */
  /**
 * Override showLoginForm untuk cek blokir DAN pass data ke view
 */
    public function showLoginForm()
    {
        $ipAddress = request()->ip();
        $attempt = LoginAttempt::where('ip_address', $ipAddress)->first();

        if ($attempt && $attempt->isBlocked()) {
            $seconds = $attempt->remainingBlockTime();
            
            return view('auth.login', [
                'blocked' => true,
                'remaining_time' => $seconds
            ]);
        }

        return view('auth.login');
    }

    /**
     * Override attemptLogin untuk cek rate limiting
     */
    protected function attemptLogin(Request $request)
    {
        $ipAddress = $request->ip();
        
        // Cek apakah IP sedang diblokir
        $attempt = LoginAttempt::firstOrCreate(
            ['ip_address' => $ipAddress],
            ['attempts' => 0]
        );

        if ($attempt->isBlocked()) {
            return false;
        }

        $credentials = $this->credentials($request);
        
        // Cari user berdasarkan email
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            $attempt->incrementAttempts();
            return false;
        }
        
        // Enkripsi password yang diinput dengan 3 layer
        $encryptedPassword = TripleEncryptionService::encrypt($credentials['password']);
        
        // Cek apakah password yang sudah dienkripsi cocok dengan hash di database
        if (Hash::check($encryptedPassword, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            
            // Reset attempts jika berhasil login
            $attempt->resetAttempts();
            
            return true;
        }
        
        // Tambah attempt jika gagal
        $attempt->incrementAttempts();
        
        return false;
    }

    /**
     * Override sendFailedLoginResponse untuk custom error message
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $ipAddress = $request->ip();
        $attempt = LoginAttempt::where('ip_address', $ipAddress)->first();

        if ($attempt && $attempt->isBlocked()) {
            $seconds = $attempt->remainingBlockTime();
            
            throw ValidationException::withMessages([
                $this->username() => [
                    "🚫 Too many login attempts. Please try again in {$seconds} seconds."
                ],
            ]);
        }

        throw ValidationException::withMessages([
            $this->username() => [
                trans('auth.failed') . " (Attempts: {$attempt->attempts}/{$this->maxAttempts})"
            ],
        ]);
    }

    /**
     * Login API
     */
    public function loginApi(Request $request)
    {
        $ipAddress = $request->ip();
        
        $attempt = LoginAttempt::firstOrCreate(
            ['ip_address' => $ipAddress],
            ['attempts' => 0]
        );

        if ($attempt->isBlocked()) {
            $seconds = $attempt->remainingBlockTime();
            return response()->json([
                'message' => "Too many login attempts. Please try again in {$seconds} seconds."
            ], 429);
        }

        $loginData = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('email', $loginData['email'])->first();

        if (!$user) {
            $attempt->incrementAttempts();
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        
        $encryptedPassword = TripleEncryptionService::encrypt($loginData['password']);
        
        if (Hash::check($encryptedPassword, $user->password)) {
            $attempt->resetAttempts();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['data' => $user, 'token' => $token], 200);
        }

        $attempt->incrementAttempts();
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}