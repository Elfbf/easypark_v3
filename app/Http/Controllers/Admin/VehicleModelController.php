<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VehicleModelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicleModels = VehicleModel::with('brand')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $vehicleBrands = VehicleBrand::all();

        // Tambahkan ini
        $existingModelsJson = $vehicleModels->getCollection()
            ->map(fn($m) => [
                'id'               => $m->id,
                'name'             => $m->name,
                'vehicle_brand_id' => $m->vehicle_brand_id,
            ])->toJson();

        return view('admin.vehicle-models.index', compact(
            'vehicleModels',
            'vehicleBrands',
            'search',
            'existingModelsJson' // Tambahkan ini
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
            'name'             => 'required|string|max:100',
        ]);

        try {

            $vehicleModel = VehicleModel::create([
                'vehicle_brand_id' => $request->vehicle_brand_id,
                'name'             => $request->name,
            ]);

            ActivityLog::create([
                'user_id'    => Auth::id(),
                'module'     => 'Vehicle Model',
                'activity'   => 'create_vehicle_model',
                'description' => 'Menambahkan model kendaraan ' . $vehicleModel->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url'        => request()->url(),
                'method'     => request()->method(),
            ]);

            return back()->with(
                'success',
                'Model kendaraan berhasil ditambahkan.'
            );
        } catch (QueryException $e) {

            Log::error('VehicleModel store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan model kendaraan.');
        }
    }

    public function update(Request $request, VehicleModel $vehicleModel)
    {
        $request->validate([
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
            'name'             => 'required|string|max:100',
        ]);

        try {

            $vehicleModel->update([
                'vehicle_brand_id' => $request->vehicle_brand_id,
                'name'             => $request->name,
            ]);

            ActivityLog::create([
                'user_id'    => Auth::id(),
                'module'     => 'Vehicle Model',
                'activity'   => 'update_vehicle_model',
                'description' => 'Memperbarui model kendaraan ' . $vehicleModel->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url'        => request()->url(),
                'method'     => request()->method(),
            ]);

            return back()->with(
                'success',
                'Model kendaraan berhasil diperbarui.'
            );
        } catch (QueryException $e) {

            Log::error('VehicleModel update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui model kendaraan.');
        }
    }

    public function destroy(VehicleModel $vehicleModel)
    {
        try {

            if ($vehicleModel->vehicles()->count() > 0) {
                return back()->with(
                    'error',
                    'Model kendaraan tidak bisa dihapus karena masih digunakan kendaraan.'
                );
            }

            $vehicleModelName = $vehicleModel->name;

            $vehicleModel->delete();

            ActivityLog::create([
                'user_id'    => Auth::id(),
                'module'     => 'Vehicle Model',
                'activity'   => 'delete_vehicle_model',
                'description' => 'Menghapus model kendaraan ' . $vehicleModelName,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url'        => request()->url(),
                'method'     => request()->method(),
            ]);

            return back()->with(
                'success',
                'Model kendaraan berhasil dihapus.'
            );
        } catch (QueryException $e) {

            Log::error('VehicleModel delete failed: ' . $e->getMessage());

            return back()->with(
                'error',
                'Gagal menghapus model kendaraan.'
            );
        }
    }
}
