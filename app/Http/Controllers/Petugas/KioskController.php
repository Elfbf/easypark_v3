<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Services\MqttService;
use App\Models\Vehicle;
use App\Models\ParkingRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KioskController extends Controller
{
    public function __construct(private MqttService $mqtt) {}

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

        $best      = end($history);
        $bestCount = count($history);

        if ($bestCount < 3) {
            return response()->json([
                'status' => 'collecting',
                'plat'   => $best,
                'muncul' => $bestCount,
            ]);
        }

        $sedangParkir = ParkingRecord::where('plate_number', $best)
            ->where('status', 'parked')
            ->whereNull('exit_time')
            ->first();

        $aksi    = $sedangParkir ? 'keluar' : 'masuk';
        $vehicle = Vehicle::with('user')
            ->where('plate_number', $best)
            ->where('is_active', true)
            ->first();

        Cache::forget('plat_history_' . $token);

        if (!$vehicle) {
            return response()->json([
                'status'    => 'tamu',
                'plat'      => $best,
                'aksi'      => $aksi,
                'record_id' => $sedangParkir?->id,
            ]);
        }

        $user    = $vehicle->user;
        $hasFace = $this->checkFaceExists($user->id);

        return response()->json([
            'status'    => 'found',
            'plat'      => $best,
            'aksi'      => $aksi,
            'has_face'  => $hasFace,
            'user_id'   => $user->id,
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

            $best      = end($history);
            $bestCount = count($history);
        }

        if ($bestCount < 3) {
            return response()->json([
                'status' => 'collecting',
                'plat'   => $best,
                'muncul' => $bestCount,
            ]);
        }

        $sedangParkir = ParkingRecord::where('plate_number', $best)
            ->where('status', 'parked')
            ->whereNull('exit_time')
            ->first();

        $aksi    = $sedangParkir ? 'keluar' : 'masuk';
        $vehicle = Vehicle::with('user')
            ->where('plate_number', $best)
            ->where('is_active', true)
            ->first();

        Cache::forget('plat_history_' . $token);

        if (!$vehicle) {
            return response()->json([
                'status'    => 'tamu',
                'plat'      => $best,
                'aksi'      => $aksi,
                'record_id' => $sedangParkir?->id,
            ]);
        }

        $user    = $vehicle->user;
        $hasFace = $this->checkFaceExists($user->id);

        return response()->json([
            'status'    => 'found',
            'plat'      => $best,
            'aksi'      => $aksi,
            'has_face'  => $hasFace,
            'user_id'   => $user->id,
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

    public function resetPlat()
    {
        Cache::forget('plat_history_KIOSK-PLAT');
        Cache::forget('plat_last_seen_KIOSK-PLAT');
        return response()->json(['status' => 'ok']);
    }

    // =========================================================================
    // KONFIRMASI MASUK
    // =========================================================================

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

        // ─── Simpan record masuk ──────────────────────────────────────────────
        $record = ParkingRecord::create([
            'vehicle_id'   => $vehicle?->id,
            'plate_number' => $plat,
            'entry_time'   => now(),
            'exit_time'    => null,
            'status'       => 'parked',
        ]);

        // ─── Publish MQTT → buka gerbang masuk ───────────────────────────────
        $this->mqtt->publish('gate/response', [
            'status'       => 'OPEN_GATE',
            'gate'         => 'ENTRY',
            'plate_number' => $plat,
            'record_id'    => $record->id,
        ]);

        Cache::forget('plat_history_KIOSK-PLAT');

        Cache::put('kiosk_just_confirmed', [
            'aksi'         => 'masuk',
            'plate_number' => $plat,
            'record_id'    => $record->id,
            'at'           => now()->toISOString(),
        ], now()->addSeconds(30));

        return response()->json([
            'status'       => 'success',
            'message'      => 'Kendaraan berhasil dicatat masuk parkir.',
            'record_id'    => $record->id,
            'plate_number' => $record->plate_number,
            'entry_time'   => $record->entry_time,
        ]);
    }

    // =========================================================================
    // KONFIRMASI KELUAR
    // =========================================================================

    public function konfirmasiKeluar(Request $request)
    {
        $request->validate([
            'record_id'    => 'nullable|integer',
            'plate_number' => 'nullable|string|max:20',
        ]);

        $record = null;

        // ── Cari by record_id dulu ────────────────────────────────────────────
        if ($request->filled('record_id')) {

            $record = ParkingRecord::where('id', $request->record_id)
                ->where('status', 'parked')
                ->whereNull('exit_time')
                ->first();

            Log::info('[Kiosk] Cari record keluar by id', [
                'record_id' => $request->record_id,
                'found'     => $record ? 'ya' : 'tidak',
            ]);
        }

        // ── Fallback: cari by plate_number jika record_id tidak ketemu ─────────
        if (!$record && $request->filled('plate_number')) {

            $plat   = strtoupper(trim($request->plate_number));
            $record = ParkingRecord::where('plate_number', $plat)
                ->where('status', 'parked')
                ->whereNull('exit_time')
                ->latest('entry_time')
                ->first();

            Log::info('[Kiosk] Fallback cari record keluar by plate', [
                'plate_number' => $plat,
                'found'        => $record ? 'ya' : 'tidak',
            ]);
        }

        // ── Tidak ketemu sama sekali ───────────────────────────────────────────
        if (!$record) {

            Log::warning('[Kiosk] Record parkir aktif tidak ditemukan saat keluar', [
                'record_id'    => $request->record_id,
                'plate_number' => $request->plate_number,
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Data parkir aktif tidak ditemukan. Mungkin sudah dicatat keluar sebelumnya.',
            ], 404);
        }

        // ── Update record keluar ───────────────────────────────────────────────
        $record->update([
            'exit_time' => now(),
            'status'    => 'completed', // ✅ sesuai ENUM di database
        ]);

        // ── Publish MQTT → buka gerbang keluar ────────────────────────────────
        $this->mqtt->publish('gate/response', [
            'status'       => 'OPEN_GATE',
            'gate'         => 'EXIT',
            'plate_number' => $record->plate_number,
            'record_id'    => $record->id,
        ]);

        Cache::forget('plat_history_KIOSK-PLAT');

        Cache::put('kiosk_just_confirmed', [
            'aksi'         => 'keluar',
            'plate_number' => $record->plate_number,
            'record_id'    => $record->id,
            'at'           => now()->toISOString(),
        ], now()->addSeconds(30));

        return response()->json([
            'status'       => 'success',
            'message'      => 'Kendaraan berhasil dicatat keluar.',
            'record_id'    => $record->id,
            'plate_number' => $record->plate_number,
            'exit_time'    => $record->exit_time,
        ]);
    }

    // =========================================================================
    // HELPER
    // =========================================================================

    private function checkFaceExists(int $userId): bool
    {
        $files = Storage::disk('private')->files('faces');
        return collect($files)->contains(
            fn($f) =>
            basename($f) === $userId . '.jpg' ||
                str_starts_with(basename($f), $userId . '_')
        );
    }
}