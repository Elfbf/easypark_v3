<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ParkingRecordController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $parkingRecords = ParkingRecord::with('vehicle')
            ->when($search, function ($query, $search) {
                $query->where('plate_number', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('entry_time')
            ->paginate(10)
            ->withQueryString();

        $totalRecords   = ParkingRecord::count();
        $parkedCount    = ParkingRecord::where('status', 'parked')->count();
        $completedCount = ParkingRecord::where('status', 'completed')
                            ->whereDate('exit_time', today())
                            ->count();
        $todayCount     = ParkingRecord::whereDate('entry_time', today())->count();

        return view('admin.parking-records.index', compact(
            'parkingRecords',
            'totalRecords',
            'parkedCount',
            'completedCount',
            'todayCount',
            'search',
            'status',
        ));
    }

    public function entry(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string',
            'face_photo'   => 'nullable|string',
        ]);

        $vehicle = Vehicle::where('plate_number', $request->plate_number)->first();

        $record = ParkingRecord::create([
            'vehicle_id'   => $vehicle->id ?? null,
            'plate_number' => $request->plate_number,
            'face_photo'   => $request->face_photo,
            'entry_time'   => now(),
            'status'       => 'parked',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil masuk',
            'data'    => $record,
        ]);
    }

    public function exit(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string',
        ]);

        $record = ParkingRecord::where('plate_number', $request->plate_number)
            ->where('status', 'parked')
            ->latest()
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Data parkir tidak ditemukan',
            ], 404);
        }

        $record->update([
            'exit_time' => now(),
            'status'    => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil keluar',
            'data'    => $record,
        ]);
    }

    public function forceExit(ParkingRecord $parkingRecord)
    {
        if ($parkingRecord->status !== 'parked') {
            return back()->with('error', 'Kendaraan ini sudah tidak dalam status parkir.');
        }

        $parkingRecord->update([
            'exit_time' => now(),
            'status'    => 'completed',
        ]);

        return back()->with('success', 'Kendaraan berhasil dipaksa keluar.');
    }
}