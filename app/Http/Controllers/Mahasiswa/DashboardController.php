<?php

namespace App\Http\Controllers\Mahasiswa;

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
            'module' => 'Mahasiswa Dashboard',
            'activity' => 'view_dashboard',
            'description' => Auth::user()->name . ' membuka dashboard mahasiswa',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->url(),
            'method' => request()->method(),
        ]);

        return view('mahasiswa.dashboard');
    }
}