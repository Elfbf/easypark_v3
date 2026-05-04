<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::with(['type', 'brand', 'model'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'vehicles' => $vehicles,
        ]);
    }

    public function show(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan.',
            ], 403);
        }

        $vehicle->load(['type', 'brand', 'model']);

        return response()->json([
            'success' => true,
            'vehicle' => $vehicle,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_type_id'  => 'required|exists:vehicle_types,id',
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
            'vehicle_model_id' => 'nullable|exists:vehicle_models,id',
            'plate_number'     => 'required|string|max:20|unique:vehicles,plate_number',
            'color'            => 'nullable|string|max:100',
            'vehicle_photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stnk_photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

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
            'user_id'          => $request->user()->id,
            'vehicle_type_id'  => $request->vehicle_type_id,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'vehicle_model_id' => $request->vehicle_model_id,
            'plate_number'     => strtoupper($request->plate_number),
            'color'            => $request->color,
            'vehicle_photo'    => $vehiclePhotoPath,
            'stnk_photo'       => $stnkPhotoPath,
            'is_parked'        => false,
            'parked_at'        => null,
            'is_active'        => true,
        ]);

        ActivityLog::create([
            'user_id'     => $request->user()->id,
            'module'      => 'Vehicle API',
            'activity'    => 'create_vehicle',
            'description' => 'Menambahkan kendaraan ' . $vehicle->plate_number,
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'url'         => $request->url(),
            'method'      => $request->method(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil ditambahkan.',
            'vehicle' => $vehicle->load(['type', 'brand', 'model']),
        ]);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan.',
            ], 403);
        }

        $request->validate([
            'vehicle_type_id'  => 'required|exists:vehicle_types,id',
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
            'vehicle_model_id' => 'nullable|exists:vehicle_models,id',
            'plate_number'     => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'color'            => 'nullable|string|max:100',
            'vehicle_photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stnk_photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $vehiclePhotoPath = $vehicle->vehicle_photo;
        if ($request->hasFile('vehicle_photo')) {
            if ($vehicle->vehicle_photo && Storage::disk('public')->exists($vehicle->vehicle_photo)) {
                Storage::disk('public')->delete($vehicle->vehicle_photo);
            }
            $vehiclePhotoPath = $request->file('vehicle_photo')
                ->store('vehicles/photos', 'public');
        }

        $stnkPhotoPath = $vehicle->stnk_photo;
        if ($request->hasFile('stnk_photo')) {
            if ($vehicle->stnk_photo && Storage::disk('public')->exists($vehicle->stnk_photo)) {
                Storage::disk('public')->delete($vehicle->stnk_photo);
            }
            $stnkPhotoPath = $request->file('stnk_photo')
                ->store('vehicles/stnk', 'public');
        }

        $vehicle->update([
            'vehicle_type_id'  => $request->vehicle_type_id,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'vehicle_model_id' => $request->vehicle_model_id,
            'plate_number'     => strtoupper($request->plate_number),
            'color'            => $request->color,
            'vehicle_photo'    => $vehiclePhotoPath,
            'stnk_photo'       => $stnkPhotoPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil diperbarui.',
            'vehicle' => $vehicle->fresh()->load(['type', 'brand', 'model']),
        ]);
    }

    public function destroy(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan.',
            ], 403);
        }

        if ($vehicle->vehicle_photo && Storage::disk('public')->exists($vehicle->vehicle_photo)) {
            Storage::disk('public')->delete($vehicle->vehicle_photo);
        }

        if ($vehicle->stnk_photo && Storage::disk('public')->exists($vehicle->stnk_photo)) {
            Storage::disk('public')->delete($vehicle->stnk_photo);
        }

        $vehicle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil dihapus.',
        ]);
    }

    // vehicle_brands tidak punya vehicle_type_id — kembalikan semua brand
    public function types()
    {
        $types = VehicleType::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data'    => $types,
        ]);
    }

    public function brandsByType(int $typeId)
    {
        // vehicle_brands tidak punya vehicle_type_id di migration
        // kembalikan semua brand
        $brands = VehicleBrand::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data'    => $brands,
        ]);
    }

    public function modelsByBrand(int $brandId)
    {
        $models = VehicleModel::where('vehicle_brand_id', $brandId)
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $models,
        ]);
    }

    // vehicle_models tidak punya vehicle_type_id di migration
    public function storeModel(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:100',
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
        ]);

        $model = VehicleModel::firstOrCreate([
            'name'             => $request->name,
            'vehicle_brand_id' => $request->vehicle_brand_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Model kendaraan berhasil disimpan.',
            'data'    => $model,
        ], 201);
    }
}
