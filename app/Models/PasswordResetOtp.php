<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expired_at',
        'is_used',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'is_used'    => 'boolean',
    ];

    // Cek apakah OTP masih valid
    public function isValid(): bool
    {
        return !$this->is_used && $this->expired_at->isFuture();
    }
}