<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\VehicleBrand;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VehicleBrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicleBrands = VehicleBrand::when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.vehicle-brands.index', compact('vehicleBrands', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_brands,name',
        ]);

        try {

            $vehicleBrand = VehicleBrand::create([
                'name' => ucfirst(strtolower($request->name))
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle Brand',
                'activity' => 'create_vehicle_brand',
                'description' => 'Menambahkan brand kendaraan ' . $vehicleBrand->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Brand kendaraan berhasil ditambahkan.');

        } catch (QueryException $e) {

            Log::error('VehicleBrand store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan brand kendaraan.');
        }
    }

    public function update(Request $request, VehicleBrand $vehicleBrand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_brands,name,' . $vehicleBrand->id,
        ]);

        try {

            $vehicleBrand->update([
                'name' => ucfirst(strtolower($request->name))
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle Brand',
                'activity' => 'update_vehicle_brand',
                'description' => 'Memperbarui brand kendaraan ' . $vehicleBrand->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Brand kendaraan berhasil diperbarui.');

        } catch (QueryException $e) {

            Log::error('VehicleBrand update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui brand kendaraan.');
        }
    }

    public function destroy(VehicleBrand $vehicleBrand)
    {
        try {

            if ($vehicleBrand->vehicles()->count() > 0) {
                return back()->with(
                    'error',
                    'Brand kendaraan tidak bisa dihapus karena masih digunakan.'
                );
            }

            $vehicleBrandName = $vehicleBrand->name;

            $vehicleBrand->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Vehicle Brand',
                'activity' => 'delete_vehicle_brand',
                'description' => 'Menghapus brand kendaraan ' . $vehicleBrandName,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Brand kendaraan berhasil dihapus.');

        } catch (QueryException $e) {

            Log::error('VehicleBrand delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus brand kendaraan.');
        }
    }
}