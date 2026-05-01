<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $activeUsers = User::where('is_active', true)->count();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Landing Page',
            'activity' => 'view_landing_page',
            'description' => 'Mengakses halaman landing page',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->url(),
            'method' => request()->method(),
        ]);

        return view('landing.index', compact('activeUsers'));
    }
}