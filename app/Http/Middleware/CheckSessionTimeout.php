<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity_time');
            $currentTime = time();
            
            // Set last activity time jika belum ada
            if (!$lastActivity) {
                session(['last_activity_time' => $currentTime]);
                return $next($request);
            }
            
            // Cek apakah sudah idle lebih dari 15 menit (900 detik)
            $idleTime = $currentTime - $lastActivity;
            
            if ($idleTime > 900) { // 15 menit = 900 detik
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->with('message', '⏰ Your session has expired due to inactivity. Please login again.');
            }
            
            // Update last activity time
            session(['last_activity_time' => $currentTime]);
        }
        
        return $next($request);
    }
}