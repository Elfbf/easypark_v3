<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\ParkingRecord;

class KioskController extends Controller
{
    public function index(): View
    {
        return view('petugas.kiosk.index');
    }

    public function cekPlat(Request $request)
    {
        $token   = "KIOSK-PLAT";
        $history = Cache::get('plat_history_' . $token, []);

        if (empty($history)) {
            return response()->json([
                'status' => 'waiting',
                'pesan'  => 'Menunggu scan...',
            ]);
        }

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

        if (!$vehicle) {
            Cache::forget('plat_history_' . $token);
            return response()->json([
                'status' => 'not_found',
                'plat'   => $best,
                'pesan'  => 'Kendaraan tidak terdaftar',
            ]);
        }

        $user = $vehicle->user;

        // ✅ Cek face photo di private storage
        $facePath = 'faces/' . $user->id . '.jpg';
        $hasFace  = Storage::disk('private')->exists($facePath);

        Cache::forget('plat_history_' . $token);

        return response()->json([
            'status' => 'found',
            'plat'   => $best,
            'has_face' => $hasFace, // ✅ blade tahu apakah perlu scan wajah
            'mahasiswa' => [
                'nama'    => $user->name,
                'nim_nip' => $user->nim_nip ?? '-',
                'foto'    => $user->photo ?? null,
            ],
            'kendaraan' => [
                'id'    => $vehicle->id,
                'plat'  => $vehicle->plate_number,
                'warna' => $vehicle->color,
                'foto'  => $vehicle->vehicle_photo ?? null,
            ],
        ]);
    }

    public function scanPlat(Request $request)
    {
        $token  = "KIOSK-PLAT";
        $plat   = strtoupper(trim($request->plat));
        $manual = $request->manual ?? false;

        if ($manual) {
            $best      = $plat;
            $bestCount = 3;
        } else {
            $history   = Cache::get('plat_history_' . $token, []);
            $history[] = $plat;
            if (count($history) > 5) array_shift($history);
            Cache::put('plat_history_' . $token, $history, 60);

            $counts = array_count_values($history);
            arsort($counts);
            $best      = array_key_first($counts);
            $bestCount = $counts[$best];
        }

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

        if (!$vehicle) {
            Cache::forget('plat_history_' . $token);
            return response()->json([
                'status' => 'not_found',
                'plat'   => $best,
                'pesan'  => 'Kendaraan tidak terdaftar',
            ], 404);
        }

        $user = $vehicle->user;

        // ✅ Cek face photo
        $facePath = 'faces/' . $user->id . '.jpg';
        $hasFace  = Storage::disk('private')->exists($facePath);

        Cache::forget('plat_history_' . $token);

        return response()->json([
            'status'   => 'found',
            'plat'     => $best,
            'has_face' => $hasFace,
            'mahasiswa' => [
                'nama'    => $user->name,
                'nim_nip' => $user->nim_nip ?? '-',
                'foto'    => $user->photo ?? null,
            ],
            'kendaraan' => [
                'id'    => $vehicle->id,
                'plat'  => $vehicle->plate_number,
                'warna' => $vehicle->color,
                'foto'  => $vehicle->vehicle_photo ?? null,
            ],
        ]);
    }

    public function konfirmasiMasuk(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20',
            'role'         => 'required|in:mahasiswa,tamu',
        ]);

        $plat = strtoupper(trim($request->plate_number));

        $vehicle = Vehicle::where('plate_number', $plat)
            ->where('is_active', true)
            ->first();

        $sudahParkir = ParkingRecord::where('plate_number', $plat)
            ->where('status', 'parked')
            ->whereNull('exit_time')
            ->first();

        if ($sudahParkir) {
            return response()->json([
                'status'    => 'already_parked',
                'message'   => 'Kendaraan ini masih tercatat sedang parkir.',
                'record_id' => $sudahParkir->id,
            ], 409);
        }

        $record = ParkingRecord::create([
            'vehicle_id'  => $vehicle ? $vehicle->id : null,
            'plate_number' => $plat,
            'face_photo'  => null,
            'entry_time'  => now(),
            'exit_time'   => null,
            'status'      => 'parked',
        ]);

        Cache::forget('plat_history_KIOSK-PLAT');

        return response()->json([
            'status'       => 'success',
            'message'      => 'Kendaraan berhasil dicatat masuk parkir.',
            'record_id'    => $record->id,
            'plate_number' => $record->plate_number,
            'entry_time'   => $record->entry_time,
        ]);
    }
}
