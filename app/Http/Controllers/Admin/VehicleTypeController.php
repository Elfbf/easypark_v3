<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VehicleTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicleTypes = VehicleType::when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.vehicle-types.index', compact('vehicleTypes', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_types,name',
        ]);

        try {

            $vehicleType = VehicleType::create([
                'name' => strtolower($request->name)
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle Type',
                'activity' => 'create_vehicle_type',
                'description' => 'Menambahkan tipe kendaraan ' . $vehicleType->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Tipe kendaraan berhasil ditambahkan.');

        } catch (QueryException $e) {

            Log::error('VehicleType store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan tipe kendaraan.');
        }
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_types,name,' . $vehicleType->id,
        ]);

        try {

            $vehicleType->update([
                'name' => strtolower($request->name)
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle Type',
                'activity' => 'update_vehicle_type',
                'description' => 'Memperbarui tipe kendaraan ' . $vehicleType->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Tipe kendaraan berhasil diperbarui.');

        } catch (QueryException $e) {

            Log::error('VehicleType update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tipe kendaraan.');
        }
    }

    public function destroy(VehicleType $vehicleType)
    {
        try {

            if ($vehicleType->vehicles()->count() > 0) {
                return back()->with(
                    'error',
                    'Tipe kendaraan tidak bisa dihapus karena masih digunakan.'
                );
            }

            $vehicleTypeName = $vehicleType->name;

            $vehicleType->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle Type',
                'activity' => 'delete_vehicle_type',
                'description' => 'Menghapus tipe kendaraan ' . $vehicleTypeName,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Tipe kendaraan berhasil dihapus.');

        } catch (QueryException $e) {

            Log::error('VehicleType delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus tipe kendaraan.');
        }
    }
}