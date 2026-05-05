<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ScanPlatController extends Controller
{
    // Python kirim plat ke sini
    public function terima(Request $request)
    {
        $token = "KIOSK-PLAT";
        $plat  = strtoupper(trim($request->plat));

        $history = Cache::get('plat_history_' . $token, []);
        array_push($history, $plat);
        if (count($history) > 5) array_shift($history);
        Cache::put('plat_history_' . $token, $history, 60);

        $counts = array_count_values($history);
        arsort($counts);
        $best      = array_key_first($counts);
        $bestCount = $counts[$best];

        // Belum confident — kumpulkan dulu
        if ($bestCount < 3) {
            return response()->json([
                'status' => 'collecting',
                'plat'   => $best,
                'muncul' => $bestCount,
            ]);
        }

        // ✅ Confident — cari kendaraan dan user
        $vehicle = Vehicle::with('user')
            ->where('plate_number', $best)
            ->where('is_active', true)
            ->first();

        if (!$vehicle || !$vehicle->user) {
            Cache::forget('plat_history_' . $token);
            return response()->json([
                'status' => 'not_found',
                'plat'   => $best,
                'pesan'  => 'Kendaraan tidak terdaftar',
            ]);
        }

        $user = $vehicle->user;

        // Cek apakah user punya face photo di private storage
        $facePath    = 'faces/' . $user->id . '.jpg';
        $hasFace     = Storage::disk('private')->exists($facePath);

        // URL untuk Python download face photo
        $facePhotoUrl = $hasFace
            ? url('/api/face-photo/' . $user->id)
            : null;

        Cache::forget('plat_history_' . $token);

        return response()->json([
            'status'        => 'confident',
            'plat'          => $best,
            'muncul'        => $bestCount,
            'vehicle_id'    => $vehicle->id,
            'user_id'       => $user->id,
            'has_face'      => $hasFace,
            'face_photo_url' => $facePhotoUrl, // ✅ Python pakai ini
            'mahasiswa' => [
                'nama'   => $user->name,
                'nim_nip' => $user->nim_nip ?? '-',
            ],
        ]);
    }

    // ✅ Endpoint baru — Python download face photo referensi
    public function getFacePhoto(int $userId)
    {
        $facePath = 'faces/' . $userId . '.jpg';

        if (!Storage::disk('private')->exists($facePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Face photo tidak ditemukan.',
            ], 404);
        }

        return response()->file(
            Storage::disk('private')->path($facePath),
            ['Content-Type' => 'image/jpeg']
        );
    }
}
