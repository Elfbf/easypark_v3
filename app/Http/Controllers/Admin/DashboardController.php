<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\ParkingArea;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ── Statistik Global (DINAMIS) ──
        $totalSlots   = ParkingSlot::where('is_active', true)->count();
        $takenSlots   = ParkingSlot::where('is_active', true)->where('status', 'taken')->count();
        $freeSlots    = ParkingSlot::where('is_active', true)->where('status', 'available')->count();
        $blockedSlots = ParkingSlot::where('is_active', true)->where('status', 'blocked')->count();

        // ── Kapasitas per Zona (DINAMIS) ──
        $zones = ParkingArea::withCount([
            'parkingSlots as total_slots' => fn($q) => $q->where('is_active', true),
            'parkingSlots as taken_slots' => fn($q) => $q->where('is_active', true)->where('status', 'taken'),
        ])->get();

        // ── Semua zona beserta slot-nya untuk peta (DINAMIS) ──
        $zonesWithSlots = ParkingArea::with(['parkingSlots' => function ($q) {
            $q->where('is_active', true)->select('id', 'parking_area_id', 'slot_code', 'status');
        }])->get()->map(function ($area) {
            return [
                'name'        => $area->name,
                'total'       => $area->parkingSlots->count(),
                'taken'       => $area->parkingSlots->where('status', 'taken')->count(),
                'available'   => $area->parkingSlots->where('status', 'available')->count(),
                'blocked'     => $area->parkingSlots->where('status', 'blocked')->count(),
                'slots'       => $area->parkingSlots->map(function ($s) {
                    return [
                        'id'     => $s->slot_code,
                        'status' => match ($s->status) {
                            'taken'     => 'taken',
                            'available' => 'free',
                            'blocked'   => 'blocked',
                            default     => 'free',
                        },
                    ];
                })->values(),
            ];
        });

        return view('admin.dashboard', compact(
            'totalSlots',
            'takenSlots',
            'freeSlots',
            'blockedSlots',
            'zones',
            'zonesWithSlots',
        ));
    }
}