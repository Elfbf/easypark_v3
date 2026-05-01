<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Petugas Dashboard',
            'activity' => 'view_dashboard',
            'description' => Auth::user()->name . ' membuka dashboard petugas',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->url(),
            'method' => request()->method(),
        ]);

        return view('petugas.dashboard');
    }
}