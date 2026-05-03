<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\ParkingArea;
use App\Models\ParkingRecord;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('petugas.dashboard', $this->getDashboardData());
    }

    // ── Core data builder ──
    private function getDashboardData(): array
    {
        $totalSlots   = ParkingSlot::where('is_active', true)->count();
        $takenSlots   = ParkingSlot::where('is_active', true)->where('status', 'occupied')->count();
        $freeSlots    = ParkingSlot::where('is_active', true)->where('status', 'available')->count();
        $blockedSlots = ParkingSlot::where('is_active', true)->where('status', 'blocked')->count();

        $zonesWithSlots = ParkingArea::with([
            'parkingSlots' => fn($q) => $q->where('is_active', true)
                ->select('id', 'parking_area_id', 'slot_code', 'status'),
        ])->get()->map(function ($area) {
            return [
                'name'        => $area->name,
                'total'       => $area->parkingSlots->count(),
                'taken'       => $area->parkingSlots->where('status', 'occupied')->count(),
                'available'   => $area->parkingSlots->where('status', 'available')->count(),
                'maintenance' => $area->parkingSlots->where('status', 'maintenance')->count(),
                'slots'       => $area->parkingSlots->map(fn($s) => [
                    'id'     => $s->slot_code,
                    'status' => match ($s->status) {
                        'occupied'    => 'taken',
                        'available'   => 'free',
                        'maintenance' => 'maintenance',
                        default       => 'free',
                    },
                ])->values(),
            ];
        });

        $todayIn        = ParkingRecord::whereDate('entry_time', today())->count();
        $todayCompleted = ParkingRecord::whereDate('entry_time', today())->where('status', 'completed')->count();

        // ── Aktivitas terkini ──
        $rawRecords = ParkingRecord::with([
            'vehicle.user', 'vehicle.type', 'vehicle.brand', 'vehicle.model',
        ])
            ->whereDate('entry_time', today())
            ->latest('entry_time')
            ->take(10)
            ->get();

        $recentActivities = $rawRecords
            ->flatMap(function ($rec) {
                $events = [['record' => $rec, 'type' => 'in', 'time' => $rec->entry_time]];
                if ($rec->exit_time) {
                    $events[] = ['record' => $rec, 'type' => 'out', 'time' => $rec->exit_time];
                }
                return $events;
            })
            ->sortByDesc('time')
            ->values()
            ->take(5);

        $capacityAlert = $totalSlots > 0 && ($freeSlots / $totalSlots) <= 0.10;

        return compact(
            'totalSlots', 'takenSlots', 'freeSlots', 'blockedSlots',
            'zonesWithSlots',
            'todayIn', 'todayCompleted',
            'recentActivities',
            'capacityAlert',
        );
    }
}