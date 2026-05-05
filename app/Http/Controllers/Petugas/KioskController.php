<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Vehicle;

class KioskController extends Controller
{
    public function index(): View
    {
        return view('petugas.kiosk.index');
    }

    // Blade polling ke sini
    public function cekPlat(Request $request)
    {
        $token = "KIOSK-PLAT";
        $history = Cache::get('plat_history_' . $token, []);

        if (empty($history)) {
            return response()->json([
                "status" => "waiting",
                "pesan" => "Menunggu scan..."
            ]);
        }

        $counts = array_count_values($history);
        arsort($counts);
        $best = array_key_first($counts);
        $bestCount = $counts[$best];

        if ($bestCount < 3) {
            return response()->json([
                "status" => "collecting",
                "plat" => $best,
                "muncul" => $bestCount,
            ]);
        }

        $vehicle = Vehicle::where('plate_number', $best)
                          ->where('is_active', true)
                          ->first();

        if (!$vehicle) {
            Cache::forget('plat_history_' . $token);
            return response()->json([
                "status" => "not_found",
                "plat" => $best,
                "pesan" => "Kendaraan tidak terdaftar"
            ]);
        }

        $user = $vehicle->user;
        Cache::forget('plat_history_' . $token);

        return response()->json([
            "status" => "found",
            "plat" => $best,
            "mahasiswa" => [
                "nama" => $user->name,
                "nim_nip" => $user->nim_nip ?? '-',
                "foto" => $user->photo ?? null,
            ],
            "kendaraan" => [
                "plat" => $vehicle->plate_number,
                "warna" => $vehicle->color,
                "foto" => $vehicle->vehicle_photo ?? null,
            ]
        ]);
    }

    // Manual input dari blade
    public function scanPlat(Request $request)
    {
        $token = "KIOSK-PLAT";
        $plat = $request->plat;
        $manual = $request->manual ?? false;

        if ($manual) {
            $best = $plat;
            $bestCount = 3;
        } else {
            $history = Cache::get('plat_history_' . $token, []);
            array_push($history, $plat);
            if (count($history) > 5) array_shift($history);
            Cache::put('plat_history_' . $token, $history, 60);

            $counts = array_count_values($history);
            arsort($counts);
            $best = array_key_first($counts);
            $bestCount = $counts[$best];
        }

        if ($bestCount < 3) {
            return response()->json([
                "status" => "collecting",
                "plat" => $best,
                "muncul" => $bestCount,
            ]);
        }

        $vehicle = Vehicle::where('plate_number', $best)
                          ->where('is_active', true)
                          ->first();

        if (!$vehicle) {
            Cache::forget('plat_history_' . $token);
            return response()->json([
                "status" => "not_found",
                "plat" => $best,
                "pesan" => "Kendaraan tidak terdaftar"
            ], 404);
        }

        $user = $vehicle->user;
        Cache::forget('plat_history_' . $token);

        return response()->json([
            "status" => "found",
            "plat" => $best,
            "mahasiswa" => [
                "nama" => $user->name,
                "nim_nip" => $user->nim_nip ?? '-',
                "foto" => $user->photo ?? null,
            ],
            "kendaraan" => [
                "plat" => $vehicle->plate_number,
                "warna" => $vehicle->color,
                "foto" => $vehicle->vehicle_photo ?? null,
            ]
        ]);
    }
}