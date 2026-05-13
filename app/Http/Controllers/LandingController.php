<?php

namespace App\Http\Controllers;

use App\Models\ParkingArea;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $activeUsers = \App\Models\User::where('is_active', true)->count();

        return view('landing.index', compact('activeUsers'));
    }

    public function user(): View
    {
        $recommendations = collect();

        $mobil = ParkingArea::with('parkingSlots')
            ->withCount([
                'parkingSlots',
                'parkingSlots as available_count' => fn($q) => $q->where('status', 'available'),
            ])
            ->whereHas('parkingSlots', fn($q) => $q->where('vehicle_type_id', 2))
            ->where('is_active', true)
            ->orderByDesc('available_count')
            ->first();

        $motor = ParkingArea::with('parkingSlots')
            ->withCount([
                'parkingSlots',
                'parkingSlots as available_count' => fn($q) => $q->where('status', 'available'),
            ])
            ->whereHas('parkingSlots', fn($q) => $q->where('vehicle_type_id', 1))
            ->where('is_active', true)
            ->orderByDesc('available_count')
            ->first();

        if ($mobil) $recommendations->push($mobil);
        if ($motor) $recommendations->push($motor);

        return view('landing.user', compact('recommendations'));
    }

    /**
     * Endpoint polling: dicek landing.user tiap 2 detik.
     * Kalau ada flag kiosk_just_confirmed → kembalikan triggered=true
     * dan langsung hapus flag agar tidak dobel trigger.
     */
    public function kioskStatus()
    {
        $flag = Cache::get('kiosk_just_confirmed');

        if ($flag && $flag['aksi'] === 'masuk') {
            Cache::forget('kiosk_just_confirmed');

            return response()->json([
                'triggered' => true,
                'aksi'      => $flag['aksi'],
                'plate'     => $flag['plate_number'],
            ]);
        }

        // Kalau keluar → hapus flag tapi tidak trigger redirect
        if ($flag && $flag['aksi'] === 'keluar') {
            Cache::forget('kiosk_just_confirmed');
        }

        return response()->json([
            'triggered' => false
        ]);
    }

    public function cekSlot(): View
    {
        $recommendations = collect();

        $mobil = ParkingArea::with('parkingSlots')
            ->withCount([
                'parkingSlots',
                'parkingSlots as available_count' => fn($q) => $q->where('status', 'available'),
            ])
            ->whereHas('parkingSlots', fn($q) => $q->where('vehicle_type_id', 2))
            ->where('is_active', true)
            ->orderByDesc('available_count')
            ->first();

        $motor = ParkingArea::with('parkingSlots')
            ->withCount([
                'parkingSlots',
                'parkingSlots as available_count' => fn($q) => $q->where('status', 'available'),
            ])
            ->whereHas('parkingSlots', fn($q) => $q->where('vehicle_type_id', 1))
            ->where('is_active', true)
            ->orderByDesc('available_count')
            ->first();

        if ($mobil) $recommendations->push($mobil);
        if ($motor) $recommendations->push($motor);

        return view('landing.cek-slot', compact('recommendations'));
    }

    public function info(): View
    {
        $areas = ParkingArea::where('is_active', true)->get();

        return view('landing.info', compact('areas'));
    }
}