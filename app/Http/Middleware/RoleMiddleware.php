<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 🔥 tambahkan ini

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 🔐 cek login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 🔥 cek aktif
        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->withErrors([
                'email' => 'Akun tidak aktif'
            ]);
        }

        // 🔥 cek role
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}