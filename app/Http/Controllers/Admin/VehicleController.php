<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicles = Vehicle::with([
                'user',
                'type',
                'brand',
                'model',
                'parkingSlot'
            ])
            ->when($search, function ($query, $search) {
                $query->where('plate_number', 'like', '%' . $search . '%')
                    ->orWhere('color', 'like', '%' . $search . '%')
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('model', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('type', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        // HANYA MAHASISWA
        $users = User::whereHas('role', function ($q) {
                $q->where('name', 'mahasiswa');
            })
            ->latest()
            ->get();

        $vehicleTypes  = VehicleType::all();
        $vehicleBrands = VehicleBrand::all();
        $vehicleModels = VehicleModel::with('brand')->get();

        return view('admin.vehicles.index', compact(
            'vehicles',
            'users',
            'vehicleTypes',
            'vehicleBrands',
            'vehicleModels',
            'search'
        ));
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load([
            'user',
            'type',
            'brand',
            'model',
            'parkingSlot'
        ]);

        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'           => 'nullable|exists:users,id',
            'vehicle_type_id'   => 'required|exists:vehicle_types,id',
            'vehicle_brand_id'  => 'required|exists:vehicle_brands,id',
            'vehicle_model_id'  => 'nullable|exists:vehicle_models,id',

            'plate_number'      => 'required|string|max:20|unique:vehicles,plate_number',
            'color'             => 'nullable|string|max:100',

            'vehicle_photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stnk_photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {

            $vehiclePhotoPath = null;
            $stnkPhotoPath = null;

            if ($request->hasFile('vehicle_photo')) {
                $vehiclePhotoPath = $request->file('vehicle_photo')
                    ->store('vehicles/photos', 'public');
            }

            if ($request->hasFile('stnk_photo')) {
                $stnkPhotoPath = $request->file('stnk_photo')
                    ->store('vehicles/stnk', 'public');
            }

            $vehicle = Vehicle::create([
                'user_id'           => $request->user_id,
                'vehicle_type_id'   => $request->vehicle_type_id,
                'vehicle_brand_id'  => $request->vehicle_brand_id,
                'vehicle_model_id'  => $request->vehicle_model_id,

                'plate_number'      => strtoupper($request->plate_number),
                'color'             => $request->color,

                'vehicle_photo'     => $vehiclePhotoPath,
                'stnk_photo'        => $stnkPhotoPath,

                'is_parked'         => false,
                'parked_at'         => null,
                'is_active'         => true,
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle',
                'activity' => 'create_vehicle',
                'description' => 'Menambahkan kendaraan ' . $vehicle->plate_number,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Kendaraan berhasil ditambahkan.');

        } catch (QueryException $e) {

            Log::error('Vehicle store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan kendaraan.');
        }
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'user_id'           => 'nullable|exists:users,id',
            'vehicle_type_id'   => 'required|exists:vehicle_types,id',
            'vehicle_brand_id'  => 'required|exists:vehicle_brands,id',
            'vehicle_model_id'  => 'nullable|exists:vehicle_models,id',

            'plate_number'      => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'color'             => 'nullable|string|max:100',

            'vehicle_photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stnk_photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'is_active'         => 'nullable|boolean',
        ]);

        try {

            $vehiclePhotoPath = $vehicle->vehicle_photo;

            if ($request->hasFile('vehicle_photo')) {

                if (
                    $vehicle->vehicle_photo &&
                    Storage::disk('public')->exists($vehicle->vehicle_photo)
                ) {
                    Storage::disk('public')->delete($vehicle->vehicle_photo);
                }

                $vehiclePhotoPath = $request->file('vehicle_photo')
                    ->store('vehicles/photos', 'public');
            }

            $stnkPhotoPath = $vehicle->stnk_photo;

            if ($request->hasFile('stnk_photo')) {

                if (
                    $vehicle->stnk_photo &&
                    Storage::disk('public')->exists($vehicle->stnk_photo)
                ) {
                    Storage::disk('public')->delete($vehicle->stnk_photo);
                }

                $stnkPhotoPath = $request->file('stnk_photo')
                    ->store('vehicles/stnk', 'public');
            }

            $vehicle->update([
                'user_id'           => $request->user_id,
                'vehicle_type_id'   => $request->vehicle_type_id,
                'vehicle_brand_id'  => $request->vehicle_brand_id,
                'vehicle_model_id'  => $request->vehicle_model_id,

                'plate_number'      => strtoupper($request->plate_number),
                'color'             => $request->color,

                'vehicle_photo'     => $vehiclePhotoPath,
                'stnk_photo'        => $stnkPhotoPath,

                'is_active'         => $request->boolean('is_active'),
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle',
                'activity' => 'update_vehicle',
                'description' => 'Memperbarui kendaraan ' . $vehicle->plate_number,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Kendaraan berhasil diperbarui.');

        } catch (QueryException $e) {

            Log::error('Vehicle update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kendaraan.');
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try {

            if (
                $vehicle->vehicle_photo &&
                Storage::disk('public')->exists($vehicle->vehicle_photo)
            ) {
                Storage::disk('public')->delete($vehicle->vehicle_photo);
            }

            if (
                $vehicle->stnk_photo &&
                Storage::disk('public')->exists($vehicle->stnk_photo)
            ) {
                Storage::disk('public')->delete($vehicle->stnk_photo);
            }

            $plateNumber = $vehicle->plate_number;

            $vehicle->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle',
                'activity' => 'delete_vehicle',
                'description' => 'Menghapus kendaraan ' . $plateNumber,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Kendaraan berhasil dihapus.');

        } catch (QueryException $e) {

            Log::error('Vehicle delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus kendaraan.');
        }
    }
}