<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
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
                ->withInput($request->only('identifier', 'role'))
                ->with('error', 'Akun Anda tidak aktif. Hubungi administrator untuk informasi lebih lanjut.');
        }

        $user->update([
            'last_login_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'module' => 'Auth',
            'activity' => 'login',
            'description' => $user->name . ' login ke sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->url(),
            'method' => $request->method(),
        ]);

        return match ($user->role->name) {

            'admin' => redirect()->intended(
                route('admin.dashboard')
            ),

            'petugas' => redirect()->intended(
                route('petugas.dashboard')
            ),

            default => abort(403, 'Role tidak dikenali.'),
        };
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {

            /** @var User $user */
            $user = Auth::user() ?? abort(403);

            ActivityLog::create([
                'user_id' => $user->id,
                'module' => 'Auth',
                'activity' => 'logout',
                'description' => $user->name . ' logout dari sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->url(),
                'method' => $request->method(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}