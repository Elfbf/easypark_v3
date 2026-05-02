<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\ParkingArea;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->query('search');
        $areaFilter = $request->query('parking_area_id');

        $parkingSlots = ParkingSlot::with(['parkingArea', 'vehicleType'])
            ->whereHas('parkingArea', fn($q) => $q->where('is_active', true))
            ->when($search, fn($query, $search) =>
                $query->where('slot_code', 'like', "%{$search}%")
            )
            ->when($areaFilter, fn($query) =>
                $query->where('parking_area_id', $areaFilter)
            )
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $parkingAreas = ParkingArea::where('is_active', true)->get();
        $vehicleTypes = VehicleType::all();

        return view('petugas.parking-slots.index', compact(
            'parkingSlots',
            'parkingAreas',
            'vehicleTypes',
            'search',
            'areaFilter'
        ));
    }
}