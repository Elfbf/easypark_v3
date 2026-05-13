<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ParkingRecord;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('petugas.dashboard', $this->getDashboardData());
    }

    private function getDashboardData(): array
    {
        // ── Statistik kendaraan ──
        $todayIn = ParkingRecord::whereDate('entry_time', today())->count();

        $todayCompleted = ParkingRecord::whereDate('entry_time', today())
            ->where('status', 'completed')
            ->count();

        $currentlyParked = ParkingRecord::whereDate('entry_time', today())
            ->where('status', 'parking')
            ->count();

        // ── Rata-rata durasi parkir ──
        $avgDurasiMins = ParkingRecord::whereDate('entry_time', today())
            ->whereNotNull('exit_time')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, entry_time, exit_time)) as avg_mins')
            ->value('avg_mins');

        $avgDurasiMins = $avgDurasiMins ? (int) $avgDurasiMins : null;

        $avgDurasi = match (true) {
            $avgDurasiMins === null => '-',
            $avgDurasiMins < 60    => $avgDurasiMins . ' menit',
            default                => floor($avgDurasiMins / 60) . ' jam ' . ($avgDurasiMins % 60) . ' menit',
        };

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

        return compact(
            'todayIn', 'todayCompleted', 'currentlyParked',
            'avgDurasi', 'avgDurasiMins',
            'recentActivities',
        );
    }
}