<?php

use App\Models\LoginAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $ipAddress = request()->ip();
        
        // CEK APAKAH IP SEDANG DIBLOKIR
        $attempt = LoginAttempt::firstOrCreate(
            ['ip_address' => $ipAddress],
            ['attempts' => 0]
        );

        if ($attempt->isBlocked()) {
            $seconds = $attempt->remainingBlockTime();
            
            session()->flash('blocked', true);
            session()->flash('remaining_time', $seconds);
            
            $this->addError('email', "🚫 Too many login attempts. Please try again in {$seconds} seconds.");
            return;
        }

        // VALIDASI INPUT
        $validated = $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // ATTEMPT LOGIN
        if (!Auth::attempt($validated, $this->remember)) {
            $attempt->incrementAttempts();
            
            $this->addError('email', trans('auth.failed') . " (Attempts: {$attempt->attempts}/5)");
            return;
        }

        // RESET ATTEMPTS JIKA LOGIN BERHASIL
        $attempt->resetAttempts();
        
        Session::regenerate();
        
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    @if(session('message'))
    <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ session('message') }}</p>
            </div>
            <button type="button" class="ml-auto text-yellow-400 hover:text-yellow-600" onclick="this.parentElement.parentElement.remove()">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    @endif

    @if(session('blocked') && session('remaining_time'))
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded" 
         data-remaining-time="{{ session('remaining_time') }}"
         id="blocked-alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-bold">🚫 Too Many Login Attempts!</h3>
                <div class="mt-2 text-sm">
                    <p>Your account has been temporarily locked for security reasons.</p>
                    <p class="mt-1">Please try again in <strong><span id="countdown">{{ session('remaining_time') }}</span> seconds</strong>.</p>
                </div>
                <div class="mt-3">
                    <div class="w-full bg-red-200 rounded-full h-2">
                        <div class="bg-red-600 h-2 rounded-full transition-all duration-1000" 
                             id="progress-bar" 
                             style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" 
                          id="email" 
                          class="block mt-1 w-full" 
                          type="email" 
                          name="email" 
                          required 
                          autofocus 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" 
                          id="password" 
                          class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required 
                          autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="remember" 
                       id="remember" 
                       type="checkbox" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                   href="{{ route('password.request') }}" 
                   wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            @if(session('blocked'))
                <button type="button" disabled class="ms-3 inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed opacity-50">
                    🔒 {{ __('Account Locked') }}
                </button>
            @else
                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            @endif
        </div>
    </form>

    <div class='text-center mt-4'>
        <p>Or login with</p>
        <a href="{{ route('auth.google') }}">
            <i class="bi bi-google" style="color:red;font-size:30px;margin:5px"></i>
        </a>
        <i class="bi bi-github" style="color:grey;font-size:30px;margin:5px"></i>
    </div>

    <div class="flex items-center justify-center mt-4">
        <p class="text-sm text-gray-600">
            {{ __("Don't have an account?") }}
        </p>
        <a href="{{ route('register') }}" 
           class="ml-2 text-sm text-indigo-600 hover:text-indigo-900"
           wire:navigate>
            {{ __('Sign up') }}
        </a>
    </div>

    @if(!session('blocked'))
    <div class="mt-6 p-3 bg-gray-50 rounded-lg border border-gray-200">
        <p class="text-xs text-gray-600 flex items-start">
            <svg class="h-4 w-4 text-gray-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span><strong>Security Notice:</strong> After 5 failed login attempts, your account will be temporarily locked for 5 minutes.</span>
        </p>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const blockedAlert = document.getElementById('blocked-alert');
            
            if (blockedAlert) {
                let timeLeft = parseInt(blockedAlert.dataset.remainingTime);
                const totalTime = timeLeft;
                const countdownEl = document.getElementById('countdown');
                const progressBar = document.getElementById('progress-bar');
                
                if (timeLeft > 0 && countdownEl && progressBar) {
                    const countdown = setInterval(function() {
                        timeLeft--;
                        countdownEl.textContent = timeLeft;
                        
                        const percentage = (timeLeft / totalTime) * 100;
                        progressBar.style.width = percentage + '%';
                        
                        if (timeLeft <= 0) {
                            clearInterval(countdown);
                            window.location.reload();
                        }
                    }, 1000);
                }
            }
        });
    </script>
</div>