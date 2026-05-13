<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', $this->getDashboardData());
    }

    // ─────────────────────────────────────────
    // AJAX REFRESH
    // ─────────────────────────────────────────
    public function refresh(): JsonResponse
    {
        $todayIn = ParkingRecord::whereDate('entry_time', today())
            ->count();

        $todayCompleted = ParkingRecord::whereDate('entry_time', today())
            ->where('status', 'completed')
            ->count();

        // Kendaraan sedang parkir
        $currentlyParked = ParkingRecord::whereDate('entry_time', today())
            ->where('status', 'parking')
            ->count();

        // ── Rata-rata durasi ──
        $avgDurasiMins = ParkingRecord::whereDate('entry_time', today())
            ->whereNotNull('exit_time')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, entry_time, exit_time)) as avg_mins')
            ->value('avg_mins');

        $avgDurasiMins = $avgDurasiMins
            ? (int) $avgDurasiMins
            : null;

        $avgDurasi = match (true) {
            $avgDurasiMins === null => '-',
            $avgDurasiMins < 60 => $avgDurasiMins . ' mnt',
            default => floor($avgDurasiMins / 60) . ' jam ' . ($avgDurasiMins % 60) . ' mnt',
        };

        // ── Aktivitas ──
        $rawRecords = ParkingRecord::with([
            'vehicle.user',
            'vehicle.type',
            'vehicle.brand',
            'vehicle.model',
        ])
            ->whereDate('entry_time', today())
            ->latest('entry_time')
            ->take(10)
            ->get();

        $recentActivities = $rawRecords
            ->flatMap(function ($rec) {

                $vehLabel = trim(implode(' ', array_filter([
                    optional(optional($rec->vehicle)->type)->name,
                    optional(optional($rec->vehicle)->brand)->name,
                    optional(optional($rec->vehicle)->model)->name,
                ]))) ?: 'Kendaraan';

                $events = [[
                    'plate'    => $rec->plate_number,
                    'type'     => 'in',
                    'time'     => $rec->entry_time?->format('H:i') ?? '-',
                    'name'     => optional(optional($rec->vehicle)->user)->name ?? '-',
                    'vehType'  => strtolower(optional(optional($rec->vehicle)->type)->name ?? 'motor'),
                    'vehLabel' => $vehLabel,
                    'fotoUrl'  => $rec->face_photo
                        ? asset('storage/' . $rec->face_photo)
                        : null,
                    'sortTime' => $rec->entry_time?->timestamp ?? 0,
                ]];

                if ($rec->exit_time) {
                    $events[] = [
                        'plate'    => $rec->plate_number,
                        'type'     => 'out',
                        'time'     => $rec->exit_time->format('H:i'),
                        'name'     => optional(optional($rec->vehicle)->user)->name ?? '-',
                        'vehType'  => strtolower(optional(optional($rec->vehicle)->type)->name ?? 'motor'),
                        'vehLabel' => $vehLabel,
                        'fotoUrl'  => $rec->face_photo
                            ? asset('storage/' . $rec->face_photo)
                            : null,
                        'sortTime' => $rec->exit_time->timestamp,
                    ];
                }

                return $events;
            })
            ->sortByDesc('sortTime')
            ->values()
            ->take(5)
            ->toArray();

        return response()->json([
            'todayIn'          => $todayIn,
            'todayCompleted'   => $todayCompleted,
            'currentlyParked'  => $currentlyParked,
            'avgDurasi'        => $avgDurasi,
            'avgDurasiMins'    => $avgDurasiMins,
            'recentActivities' => array_values($recentActivities),
        ]);
    }

    // ─────────────────────────────────────────
    // DASHBOARD DATA
    // ─────────────────────────────────────────
    private function getDashboardData(): array
    {
        // Kendaraan masuk hari ini
        $todayIn = ParkingRecord::whereDate('entry_time', today())
            ->count();

        // Kendaraan selesai parkir
        $todayCompleted = ParkingRecord::whereDate('entry_time', today())
            ->where('status', 'completed')
            ->count();

        // Kendaraan sedang parkir
        $currentlyParked = ParkingRecord::whereDate('entry_time', today())
            ->where('status', 'parking')
            ->count();

        // ─────────────────────────────────────
        // RATA-RATA DURASI PARKIR
        // ─────────────────────────────────────
        $avgDurasiMins = ParkingRecord::whereDate('entry_time', today())
            ->whereNotNull('exit_time')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, entry_time, exit_time)) as avg_mins')
            ->value('avg_mins');

        $avgDurasiMins = $avgDurasiMins
            ? (int) $avgDurasiMins
            : null;

        $avgDurasi = match (true) {
            $avgDurasiMins === null => '-',
            $avgDurasiMins < 60 => $avgDurasiMins . ' menit',
            default => floor($avgDurasiMins / 60) . ' jam ' . ($avgDurasiMins % 60) . ' menit',
        };

        // ─────────────────────────────────────
        // AKTIVITAS TERBARU
        // ─────────────────────────────────────
        $rawRecords = ParkingRecord::with([
            'vehicle.user',
            'vehicle.type',
            'vehicle.brand',
            'vehicle.model',
        ])
            ->whereDate('entry_time', today())
            ->latest('entry_time')
            ->take(10)
            ->get();

        $recentActivities = $rawRecords
            ->flatMap(function ($rec) {

                $events = [[
                    'record' => $rec,
                    'type'   => 'in',
                    'time'   => $rec->entry_time,
                ]];

                if ($rec->exit_time) {
                    $events[] = [
                        'record' => $rec,
                        'type'   => 'out',
                        'time'   => $rec->exit_time,
                    ];
                }

                return $events;
            })
            ->sortByDesc('time')
            ->values()
            ->take(5);

        // ─────────────────────────────────────
        // DATA PER JAM
        // ─────────────────────────────────────
        $hourlyRaw = ParkingRecord::selectRaw('HOUR(entry_time) as hour, COUNT(*) as total')
            ->whereDate('entry_time', today())
            ->groupBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        $hourlyData = [];

        for ($i = 0; $i <= 23; $i++) {
            $hourlyData[$i] = $hourlyRaw[$i] ?? 0;
        }

        ksort($hourlyData);

        $maxVal = max($hourlyData);

        $peakHour = $maxVal > 0
            ? array_search($maxVal, $hourlyData)
            : null;

        $peakHourLabel = $peakHour !== null
            ? str_pad($peakHour, 2, '0', STR_PAD_LEFT) . ':00'
            : '-';

        // ─────────────────────────────────────
        // WEEKLY
        // ─────────────────────────────────────
        $weeklyData = [];

        for ($d = 6; $d >= 0; $d--) {

            $date = now()->subDays($d);

            $label = $date->format('d/m');

            $weeklyData[$label] = ParkingRecord::whereDate(
                'entry_time',
                $date->format('Y-m-d')
            )->count();
        }

        // ─────────────────────────────────────
        // MONTHLY
        // ─────────────────────────────────────
        $monthlyData = [];

        for ($d = 29; $d >= 0; $d--) {

            $date = now()->subDays($d);

            $label = $date->format('m/d');

            $monthlyData[$label] = ParkingRecord::whereDate(
                'entry_time',
                $date->format('Y-m-d')
            )->count();
        }

        // ─────────────────────────────────────
        // STATISTIK KENDARAAN
        // ─────────────────────────────────────
        $vehicleTypeStats = ParkingRecord::with('vehicle.type')
            ->whereDate('entry_time', today())
            ->get()
            ->groupBy(
                fn($r) =>
                optional(optional($r->vehicle)->type)->name
                    ?? 'Tidak Diketahui'
            )
            ->map->count()
            ->sortDesc()
            ->toArray();

        return compact(
            'todayIn',
            'todayCompleted',
            'currentlyParked',
            'avgDurasi',
            'avgDurasiMins',
            'recentActivities',
            'hourlyData',
            'peakHour',
            'peakHourLabel',
            'weeklyData',
            'monthlyData',
            'vehicleTypeStats',
        );
    }
}