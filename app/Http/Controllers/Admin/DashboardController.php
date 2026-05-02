<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\ParkingArea;
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

    // ── Endpoint AJAX — hanya kembalikan primitif, tidak ada Eloquent Collection ──
    public function refresh(): JsonResponse
    {
        $totalSlots     = ParkingSlot::where('is_active', true)->count();
        $takenSlots     = ParkingSlot::where('is_active', true)->where('status', 'occupied')->count();
        $freeSlots      = ParkingSlot::where('is_active', true)->where('status', 'available')->count();
        $todayIn        = ParkingRecord::whereDate('entry_time', today())->count();
        $todayCompleted = ParkingRecord::whereDate('entry_time', today())->where('status', 'completed')->count();

        // Zona — di-map ke plain array agar JSON bersih
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
                ])->values()->toArray(),
            ];
        })->values()->toArray();

        // Aktivitas terkini — sudah jadi array biasa, tidak ada model object
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
                    'fotoUrl'  => $rec->face_photo ? asset('storage/' . $rec->face_photo) : null,
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
                        'fotoUrl'  => $rec->face_photo ? asset('storage/' . $rec->face_photo) : null,
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
            'totalSlots'       => $totalSlots,
            'takenSlots'       => $takenSlots,
            'freeSlots'        => $freeSlots,
            'todayIn'          => $todayIn,
            'todayCompleted'   => $todayCompleted,
            'zonesWithSlots'   => $zonesWithSlots,
            'recentActivities' => array_values($recentActivities),
        ]);
    }

    // ── Export CSV ──
    public function exportCsv()
    {
        $records = ParkingRecord::with([
            'vehicle.user', 'vehicle.type', 'vehicle.brand', 'vehicle.model',
        ])
            ->whereDate('entry_time', today())
            ->latest('entry_time')
            ->get();

        $filename = 'aktivitas-parkir-' . today()->format('Y-m-d') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($records) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'No', 'Plat Nomor', 'Tipe', 'Merek', 'Model',
                'Pengemudi', 'Waktu Masuk', 'Waktu Keluar', 'Durasi', 'Status',
            ]);

            foreach ($records as $i => $rec) {
                $start    = $rec->entry_time;
                $end      = $rec->exit_time;
                $diffMins = ($start && $end) ? (int) $start->diffInMinutes($end) : null;
                $durasi   = $diffMins === null ? '-'
                    : ($diffMins < 60 ? $diffMins . ' mnt'
                        : floor($diffMins / 60) . ' jam ' . ($diffMins % 60) . ' mnt');

                fputcsv($handle, [
                    $i + 1,
                    $rec->plate_number,
                    optional(optional($rec->vehicle)->type)->name  ?? '-',
                    optional(optional($rec->vehicle)->brand)->name ?? '-',
                    optional(optional($rec->vehicle)->model)->name ?? '-',
                    optional(optional($rec->vehicle)->user)->name  ?? '-',
                    $start ? $start->format('H:i') : '-',
                    $end   ? $end->format('H:i')   : '-',
                    $durasi,
                    $rec->status ?? '-',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Core data builder — hanya dipanggil sekali saat page load ──
    private function getDashboardData(): array
    {
        $totalSlots   = ParkingSlot::where('is_active', true)->count();
        $takenSlots   = ParkingSlot::where('is_active', true)->where('status', 'occupied')->count();
        $freeSlots    = ParkingSlot::where('is_active', true)->where('status', 'available')->count();
        $blockedSlots = ParkingSlot::where('is_active', true)->where('status', 'blocked')->count();

        $zones = ParkingArea::withCount([
            'parkingSlots as total_slots' => fn($q) => $q->where('is_active', true),
            'parkingSlots as taken_slots' => fn($q) => $q->where('is_active', true)->where('status', 'occupied'),
        ])->get();

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

        $avgDurasiMins = ParkingRecord::whereDate('entry_time', today())
            ->whereNotNull('exit_time')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, entry_time, exit_time)) as avg_mins')
            ->value('avg_mins');

        $avgDurasiMins = $avgDurasiMins ? (int) $avgDurasiMins : null;
        $avgDurasi     = match (true) {
            $avgDurasiMins === null  => '-',
            $avgDurasiMins < 60     => $avgDurasiMins . ' mnt',
            default                 => floor($avgDurasiMins / 60) . ' jam ' . ($avgDurasiMins % 60) . ' mnt',
        };

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

        $hourlyData = ParkingRecord::selectRaw('HOUR(entry_time) as hour, COUNT(*) as total')
            ->whereDate('entry_time', today())
            ->groupBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        for ($i = 0; $i <= 23; $i++) {
            $hourlyData[$i] = $hourlyData[$i] ?? 0;
        }
        ksort($hourlyData);

        $peakHour      = array_search(max($hourlyData), $hourlyData);
        $peakHourLabel = str_pad($peakHour, 2, '0', STR_PAD_LEFT) . ':00';

        $weeklyData = [];
        for ($d = 6; $d >= 0; $d--) {
            $label              = now()->subDays($d)->format('d/m');
            $weeklyData[$label] = ParkingRecord::whereDate('entry_time', now()->subDays($d)->format('Y-m-d'))->count();
        }

        $vehicleTypeStats = ParkingRecord::with('vehicle.type')
            ->whereDate('entry_time', today())
            ->get()
            ->groupBy(fn($r) => optional(optional($r->vehicle)->type)->name ?? 'Tidak Diketahui')
            ->map->count()
            ->sortDesc()
            ->toArray();

        $capacityAlert = $totalSlots > 0 && ($freeSlots / $totalSlots) <= 0.10;

        return compact(
            'totalSlots', 'takenSlots', 'freeSlots', 'blockedSlots',
            'zones', 'zonesWithSlots',
            'todayIn', 'todayCompleted',
            'avgDurasi', 'avgDurasiMins',
            'recentActivities',
            'hourlyData', 'peakHour', 'peakHourLabel',
            'weeklyData', 'vehicleTypeStats',
            'capacityAlert',
        );
    }
}