<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingRecord;
use Illuminate\Http\Request;

class ParkingRecordController extends Controller
{
    // GET /api/parking-records/history
    public function history(Request $request)
    {
        $user     = $request->user();
        $vehicles = $user->vehicles()->pluck('plate_number');

        $records = ParkingRecord::whereIn('plate_number', $vehicles)
            ->with(['vehicle.type', 'vehicle.brand', 'vehicle.model'])
            ->latest('entry_time')
            ->get()
            ->map(fn($r) => [
                'plate_number'      => $r->plate_number,
                'entry_time'        => $r->entry_time,
                'exit_time'         => $r->exit_time,
                'status'            => $r->status,
                'vehicle_type_name' => $r->vehicle?->type?->name ?? '-',
            ]);

        return response()->json($records);
    }

    // GET /api/parking-records/last-status
    public function lastStatus(Request $request)
    {
        $user     = $request->user();
        $vehicles = $user->vehicles()->pluck('plate_number');

        $record = ParkingRecord::whereIn('plate_number', $vehicles)
            ->latest('entry_time')
            ->first();

        return response()->json([
            'status'     => $record?->status ?? 'none',
            'entry_time' => $record?->entry_time,
            'exit_time'  => $record?->exit_time,
        ]);
    }

    // GET /api/parking-records/last-entry-exit
    public function lastEntryExit(Request $request)
    {
        $user     = $request->user();
        $vehicles = $user->vehicles()->pluck('plate_number');

        $last = ParkingRecord::whereIn('plate_number', $vehicles)
            ->latest('entry_time')
            ->first();

        return response()->json([
            'entry_time' => $last?->entry_time,
            'exit_time'  => $last?->exit_time,
            'status'     => $last?->status ?? 'none',
            'plate'      => $last?->plate_number,
        ]);
    }
}
