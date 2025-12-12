<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LoginAttempt extends Model
{
    protected $fillable = [
        'ip_address',
        'attempts',
        'last_attempt_at',
        'blocked_until'
    ];

    protected $casts = [
        'last_attempt_at' => 'datetime',
        'blocked_until' => 'datetime',
    ];

    /**
     * Cek apakah IP sedang diblokir
     */
    public function isBlocked(): bool
    {
        if (!$this->blocked_until) {
            return false;
        }

        // Jika masih dalam masa blokir
        if (Carbon::now()->lessThan($this->blocked_until)) {
            return true;
        }

        // Jika masa blokir sudah habis, reset attempts
        $this->resetAttempts();
        return false;
    }

    /**
     * Tambah attempt
     */
    public function incrementAttempts(): void
    {
        $this->attempts++;
        $this->last_attempt_at = Carbon::now();

        // Jika sudah 5x, blokir selama 5 menit
        if ($this->attempts >= 5) {
            $this->blocked_until = Carbon::now()->addMinutes(5);
        }

        $this->save();
    }

    /**
     * Reset attempts
     */
    public function resetAttempts(): void
    {
        $this->update([
            'attempts' => 0,
            'blocked_until' => null,
            'last_attempt_at' => null
        ]);
    }

    /**
     * Waktu tersisa blokir (dalam detik)
     */
    public function remainingBlockTime(): int
    {
        if (!$this->blocked_until) {
            return 0;
        }

        return max(0, Carbon::now()->diffInSeconds($this->blocked_until, false));
    }
}