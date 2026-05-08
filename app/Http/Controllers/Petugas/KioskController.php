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

        // Cek apakah kendaraan sedang parkir (untuk logika masuk/keluar)
        $sedangParkir = ParkingRecord::where('plate_number', $best)
            ->where('status', 'parked')
            ->whereNull('exit_time')
            ->first();

        $aksi = $sedangParkir ? 'keluar' : 'masuk';

        $vehicle = Vehicle::with('user')
            ->where('plate_number', $best)
            ->where('is_active', true)
            ->first();

        Cache::forget('plat_history_' . $token);

        // Tidak terdaftar → langsung tamu
        if (!$vehicle) {
            return response()->json([
                'status'   => 'tamu',
                'plat'     => $best,
                'aksi'     => $aksi,
                'record_id' => $sedangParkir?->id,
            ]);
        }

        $user = $vehicle->user;

        // Cek face photo di private storage
        $facePath = 'faces/' . $user->id . '.jpg';
        $hasFace  = Storage::disk('private')->exists($facePath);

        return response()->json([
            'status'   => 'found',
            'plat'     => $best,
            'aksi'     => $aksi,
            'has_face' => $hasFace,
            'record_id' => $sedangParkir?->id,
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

        // Cek apakah kendaraan sedang parkir (untuk logika masuk/keluar)
        $sedangParkir = ParkingRecord::where('plate_number', $best)
            ->where('status', 'parked')
            ->whereNull('exit_time')
            ->first();

        $aksi = $sedangParkir ? 'keluar' : 'masuk';

        $vehicle = Vehicle::with('user')
            ->where('plate_number', $best)
            ->where('is_active', true)
            ->first();

        Cache::forget('plat_history_' . $token);

        // Tidak terdaftar → langsung tamu
        if (!$vehicle) {
            return response()->json([
                'status'   => 'tamu',
                'plat'     => $best,
                'aksi'     => $aksi,
                'record_id' => $sedangParkir?->id,
            ]);
        }

        $user = $vehicle->user;

        $facePath = 'faces/' . $user->id . '.jpg';
        $hasFace  = Storage::disk('private')->exists($facePath);

        return response()->json([
            'status'   => 'found',
            'plat'     => $best,
            'aksi'     => $aksi,
            'has_face' => $hasFace,
            'record_id' => $sedangParkir?->id,
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

    /**
     * Konfirmasi masuk — selalu create record baru (termasuk tamu).
     * Tidak ada pengecekan already_parked karena logika sudah di frontend.
     */
    public function konfirmasiMasuk(Request $request)
    {
        $request->validate([
            'plate_number'  => 'required|string|max:20',
            'role'          => 'required|in:mahasiswa,tamu',
            'face_verified' => 'nullable|boolean',
        ]);

        $plat = strtoupper(trim($request->plate_number));

        $vehicle = Vehicle::where('plate_number', $plat)
            ->where('is_active', true)
            ->first();

        $record = ParkingRecord::create([
            'vehicle_id'    => $vehicle?->id,
            'plate_number'  => $plat,
            'face_photo'    => null,
            'entry_time'    => now(),
            'exit_time'     => null,
            'status'        => 'parked',
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

    /**
     * Konfirmasi keluar — update record yang sedang parkir.
     */
    public function konfirmasiKeluar(Request $request)
    {
        $request->validate([
            'record_id' => 'required|integer',
        ]);

        $record = ParkingRecord::where('id', $request->record_id)
            ->where('status', 'parked')
            ->whereNull('exit_time')
            ->firstOrFail();

        $record->update([
            'exit_time' => now(),
            'status'    => 'completed',
        ]);

        Cache::forget('plat_history_KIOSK-PLAT');

        return response()->json([
            'status'       => 'success',
            'message'      => 'Kendaraan berhasil dicatat keluar.',
            'record_id'    => $record->id,
            'plate_number' => $record->plate_number,
            'exit_time'    => $record->exit_time,
        ]);
    }
}