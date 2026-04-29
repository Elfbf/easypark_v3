<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // ✅ Cek akun aktif — redirect balik dengan pesan di session
        if (! $user->is_active) {
            Auth::logout();

            return back()
                ->withInput($request->only('identifier', 'role'))
                ->with('error', 'Akun Anda tidak aktif. Hubungi administrator untuk informasi lebih lanjut.');
        }

        // ✅ Redirect berdasarkan role
        return match ($user->role->name) {
            'admin'     => redirect()->intended(route('admin.dashboard')),
            'petugas'   => redirect()->intended(route('petugas.dashboard')),
            'mahasiswa' => redirect()->intended(route('mahasiswa.dashboard')),
            default     => abort(403, 'Role tidak dikenali.'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
