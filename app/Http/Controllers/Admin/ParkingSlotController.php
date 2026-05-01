<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ParkingArea;
use App\Models\ParkingSlot;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ParkingSlotController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $parkingSlots = ParkingSlot::with([
                'parkingArea',
                'vehicleType'
            ])
            ->when($search, function ($query, $search) {
                $query->where('slot_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $parkingAreas = ParkingArea::where('is_active', true)->get();
        $vehicleTypes = VehicleType::all();

        return view('admin.parking-slots.index', compact(
            'parkingSlots',
            'parkingAreas',
            'vehicleTypes',
            'search'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parking_area_id' => 'required|exists:parking_areas,id',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'slot_code'       => 'required|string|max:50',
            'status'          => 'required|in:available,occupied,maintenance',
        ]);

        try {

            $parkingSlot = ParkingSlot::create([
                'parking_area_id' => $request->parking_area_id,
                'vehicle_type_id' => $request->vehicle_type_id,
                'slot_code'       => strtoupper($request->slot_code),
                'status'          => $request->status,
                'is_active'       => true,
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Parking Slot',
                'activity' => 'create_parking_slot',
                'description' => 'Menambahkan slot parkir ' . $parkingSlot->slot_code,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with(
                'success',
                'Slot parkir berhasil ditambahkan.'
            );

        } catch (QueryException $e) {

            Log::error('ParkingSlot store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan slot parkir.');
        }
    }

    public function update(Request $request, ParkingSlot $parkingSlot)
    {
        $request->validate([
            'parking_area_id' => 'required|exists:parking_areas,id',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'slot_code'       => 'required|string|max:50',
            'status'          => 'required|in:available,occupied,maintenance',
            'is_active'       => 'nullable|boolean',
        ]);

        try {

            $parkingSlot->update([
                'parking_area_id' => $request->parking_area_id,
                'vehicle_type_id' => $request->vehicle_type_id,
                'slot_code'       => strtoupper($request->slot_code),
                'status'          => $request->status,
                'is_active'       => $request->boolean('is_active'),
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Parking Slot',
                'activity' => 'update_parking_slot',
                'description' => 'Memperbarui slot parkir ' . $parkingSlot->slot_code,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with(
                'success',
                'Slot parkir berhasil diperbarui.'
            );

        } catch (QueryException $e) {

            Log::error('ParkingSlot update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui slot parkir.');
        }
    }

    public function destroy(ParkingSlot $parkingSlot)
    {
        try {

            if ($parkingSlot->vehicles()->count() > 0) {
                return back()->with(
                    'error',
                    'Slot parkir tidak bisa dihapus karena masih digunakan kendaraan.'
                );
            }

            $slotCode = $parkingSlot->slot_code;

            $parkingSlot->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Parking Slot',
                'activity' => 'delete_parking_slot',
                'description' => 'Menghapus slot parkir ' . $slotCode,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with(
                'success',
                'Slot parkir berhasil dihapus.'
            );

        } catch (QueryException $e) {

            Log::error('ParkingSlot delete failed: ' . $e->getMessage());

            return back()->with(
                'error',
                'Gagal menghapus slot parkir.'
            );
        }
    }
}