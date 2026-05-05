<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ScanPlatController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Helper — cari path face photo berdasarkan user_id
    | Support format lama: {user_id}.jpg
    | Support format baru: {user_id}_{nama}.jpg
    |--------------------------------------------------------------------------
    */
    private function findFacePath(int $userId): ?string
    {
        $files = Storage::disk('private')->files('faces');

        return collect($files)->first(function ($file) use ($userId) {
            $basename = basename($file);
            return $basename === $userId . '.jpg'
                || str_starts_with($basename, $userId . '_');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Terima plat dari Python
    |--------------------------------------------------------------------------
    */
    public function terima(Request $request)
    {
        $token = "KIOSK-PLAT";
        $plat  = strtoupper(trim($request->plat));

        $history   = Cache::get('plat_history_' . $token, []);
        $history[] = $plat;

        if (count($history) > 5) {
            array_shift($history);
        }

        Cache::put('plat_history_' . $token, $history, 60);

        $counts = array_count_values($history);
        arsort($counts);

        $best      = array_key_first($counts);
        $bestCount = $counts[$best];

        if ($bestCount < 3) {
            return response()->json([
                'status' => 'collecting',
                'plat'   => $best,
                'muncul' => $bestCount,
            ]);
        }

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

        // ✅ Support format lama dan baru
        $facePath = $this->findFacePath($user->id);
        $hasFace  = $facePath !== null;

        Cache::forget('plat_history_' . $token);

        return response()->json([
            'status'          => 'found',
            'plat'            => $best,
            'muncul'          => $bestCount,
            'vehicle_id'      => $vehicle->id,
            'user_id'         => $user->id,
            'has_face'        => $hasFace,
            'face_photo_url'  => $hasFace
                ? url('/api/face-photo/' . $user->id)
                : null,
            'mahasiswa' => [
                'nama'    => $user->name,
                'nim_nip' => $user->nim_nip ?? '-',
            ],
            'kendaraan' => [
                'plat'   => $vehicle->plate_number,
                'warna'  => $vehicle->color,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Download face photo — untuk Python
    |--------------------------------------------------------------------------
    */
    public function getFacePhoto(int $userId)
    {
        // ✅ Support format lama dan baru
        $facePath = $this->findFacePath($userId);

        if (!$facePath) {
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
