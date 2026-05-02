<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ParkingRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ParkingRecordController extends Controller
{
    private function baseQuery(Request $request)
    {
        $search   = $request->query('search');
        $status   = $request->query('status');
        $dateFrom = $request->query('date_from', today()->toDateString());
        $dateTo   = $request->query('date_to',   today()->toDateString());

        return ParkingRecord::with(['vehicle.type', 'vehicle.brand', 'vehicle.model'])
            ->when($search,   fn($q) => $q->where('plate_number', 'like', "%{$search}%"))
            ->when($status,   fn($q) => $q->where('status', $status))
            ->when($dateFrom, fn($q) => $q->whereDate('entry_time', '>=', $dateFrom))
            ->when($dateTo,   fn($q) => $q->whereDate('entry_time', '<=', $dateTo))
            ->latest('entry_time');
    }

    public function index(Request $request)
    {
        $search   = $request->query('search', '');
        $status   = $request->query('status', '');
        $dateFrom = $request->query('date_from', today()->toDateString());
        $dateTo   = $request->query('date_to',   today()->toDateString());

        $parkingRecords = $this->baseQuery($request)
            ->paginate(10)
            ->withQueryString();

        $parkedCount    = ParkingRecord::where('status', 'parked')->count();
        $completedCount = ParkingRecord::where('status', 'completed')
                            ->whereDate('exit_time', today())->count();
        $todayCount     = ParkingRecord::whereDate('entry_time', today())->count();

        return view('petugas.parking-records.index', compact(
            'parkingRecords',
            'parkedCount',
            'completedCount',
            'todayCount',
            'search',
            'status',
            'dateFrom',
            'dateTo',
        ));
    }

    public function entry(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string',
            'face_photo'   => 'nullable|string',
        ]);

        $vehicle = Vehicle::where('plate_number', strtoupper($request->plate_number))->first();

        $alreadyParked = ParkingRecord::where('plate_number', strtoupper($request->plate_number))
            ->where('status', 'parked')
            ->exists();

        if ($alreadyParked) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan dengan plat ini sudah tercatat parkir.',
            ], 422);
        }

        $record = ParkingRecord::create([
            'vehicle_id'   => $vehicle?->id,
            'plate_number' => strtoupper($request->plate_number),
            'face_photo'   => $request->face_photo,
            'entry_time'   => now(),
            'status'       => 'parked',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil masuk.',
            'data'    => $record,
        ]);
    }

    public function exit(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string',
        ]);

        $record = ParkingRecord::where('plate_number', strtoupper($request->plate_number))
            ->where('status', 'parked')
            ->latest('entry_time')
            ->first();

        if (! $record) {
            return response()->json([
                'success' => false,
                'message' => 'Data parkir aktif tidak ditemukan.',
            ], 404);
        }

        $record->update([
            'exit_time' => now(),
            'status'    => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil keluar.',
            'data'    => $record,
        ]);
    }
}