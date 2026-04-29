<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role'       => ['required', 'string', 'in:mahasiswa,petugas,admin'],
            'identifier' => ['required', 'string'],
            'password'   => ['required', 'string'],
        ];
    }

    /**
     * Custom attribute names untuk pesan error yang lebih ramah.
     */
    public function attributes(): array
    {
        return [
            'identifier' => match ($this->input('role')) {
                'admin'   => 'email admin',
                'petugas' => 'ID petugas',
                default   => 'NIM mahasiswa',
            },
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $role = $this->input('role');

        // Tentukan kolom DB berdasarkan role
        // Admin  → pakai kolom email
        // Petugas & Mahasiswa → pakai kolom nim_nip
        $field = match ($role) {
            'admin'   => 'email',
            default   => 'nim_nip',
        };

        $credentials = [
            $field     => $this->input('identifier'),
            'password' => $this->input('password'),
        ];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identifier' => trans('auth.failed'),
            ]);
        }

        // ✅ Pastikan role user sesuai pilihan di form
        // (mencegah mahasiswa login via tab Petugas, dll.)
        $user = Auth::user();
        if ($user->role->name !== $role) {
            Auth::logout();

            throw ValidationException::withMessages([
                'identifier' => 'Akun tidak ditemukan untuk peran yang dipilih.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
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

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('identifier')) . '|' . $this->ip()
        );
    }
}
