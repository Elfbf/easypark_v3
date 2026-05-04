<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Vehicle;

class ScanPlatController extends Controller
{
    public function terima(Request $request)
    {
        $token = $request->token;
        $plat = $request->plat;

        // Ambil history plat token ini
        $history = Cache::get('plat_history_' . $token, []);
        array_push($history, $plat);
        if (count($history) > 5) array_shift($history);
        Cache::put('plat_history_' . $token, $history, 60);

        // Hitung yang paling sering muncul
        $counts = array_count_values($history);
        arsort($counts);
        $best = array_key_first($counts);
        $bestCount = $counts[$best];

        // Belum confident
        if ($bestCount < 3) {
            return response()->json([
                "status" => "collecting",
                "plat" => $best,
                "muncul" => $bestCount,
                "pesan" => "Masih mengumpulkan data..."
            ]);
        }

        // Cari kendaraan di DB
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

        // Ambil data user
        $user = $vehicle->user;

        // Hapus cache
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