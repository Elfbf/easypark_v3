<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ParkingArea;
use App\Models\ParkingRecord;
use App\Models\ParkingSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $activeUsers = \App\Models\User::where('is_active', true)->count();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'module'     => 'Landing Page',
            'activity'   => 'view_landing_page',
            'description'=> 'Mengakses halaman landing page',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url'        => request()->url(),
            'method'     => request()->method(),
        ]);

        return view('landing.index', compact('activeUsers'));
    }

    public function user(): View
    {
        $totalSlot     = ParkingSlot::count();
        $availableSlot = ParkingSlot::where('status', 'available')->count();
        $occupiedSlot  = ParkingSlot::where('status', 'occupied')->count();
        $sedangParkir  = ParkingRecord::whereNull('exit_time')->count();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'module'     => 'User Page',
            'activity'   => 'view_user_page',
            'description'=> 'Mengakses halaman user',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url'        => request()->url(),
            'method'     => request()->method(),
        ]);

        return view('landing.user', compact(
            'totalSlot',
            'availableSlot',
            'occupiedSlot',
            'sedangParkir'
        ));
    }

    public function cekSlot(): View
    {
        $areas = ParkingArea::with(['parkingSlots'])
            ->withCount([
                'parkingSlots',
                'parkingSlots as available_count' => fn($q) => $q->where('status', 'available'),
                'parkingSlots as occupied_count'  => fn($q) => $q->where('status', 'occupied'),
            ])
            ->where('is_active', true)
            ->get();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'module'     => 'User Page',
            'activity'   => 'view_cek_slot',
            'description'=> 'Mengakses halaman cek slot parkir',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url'        => request()->url(),
            'method'     => request()->method(),
        ]);

        return view('landing.cek-slot', compact('areas'));
    }

    public function info(): View
    {
        $areas = ParkingArea::where('is_active', true)->get();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'module'     => 'User Page',
            'activity'   => 'view_info',
            'description'=> 'Mengakses halaman info parkir',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url'        => request()->url(),
            'method'     => request()->method(),
        ]);

        return view('landing.info', compact('areas'));
    }
}