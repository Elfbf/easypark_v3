<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role'       => ['required', 'string', 'in:mahasiswa,petugas,admin'],
            'identifier' => ['required', 'string'],
            'password'   => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'identifier' => match ($this->input('role')) {
                'admin'   => 'email admin',
                'petugas' => 'email atau ID petugas',
                default   => 'email atau NIM mahasiswa',
            },
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $role       = $this->input('role');
        $identifier = $this->input('identifier');
        $password   = $this->input('password');

        // ── Cari user berdasarkan role ──
        if ($role === 'admin') {
            // Admin hanya pakai email
            $user = User::where('email', $identifier)->first();

        } else {
            // Petugas & Mahasiswa → bisa pakai email ATAU nim_nip
            $user = User::where('email', $identifier)
                        ->orWhere('nim_nip', $identifier)
                        ->first();
        }

        // User tidak ditemukan atau password salah
        if (!$user || !Auth::attempt(['email' => $user->email, 'password' => $password], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identifier' => trans('auth.failed'),
            ]);
        }

        // ✅ Pastikan role user sesuai pilihan di form
        if ($user->role->name !== $role) {
            Auth::logout();

            throw ValidationException::withMessages([
                'identifier' => 'Akun tidak ditemukan untuk peran yang dipilih.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'identifier' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('identifier')) . '|' . $this->ip()
        );
    }
}