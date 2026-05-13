<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user() ?? abort(403);

        if (! $user->is_active) {
            Auth::logout();

            return back()
                ->withInput($request->only('identifier'))
                ->with('error', 'Akun Anda tidak aktif. Hubungi administrator untuk informasi lebih lanjut.');
        }

        $user->update([
            'last_login_at' => now(),
        ]);

        return match ($user->role->name) {
            'admin'   => redirect()->intended(route('admin.dashboard')),
            'petugas' => redirect()->intended(route('petugas.dashboard')),
            default   => abort(403, 'Role tidak dikenali.'),
        };
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}