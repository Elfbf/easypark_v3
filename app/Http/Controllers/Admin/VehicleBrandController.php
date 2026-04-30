<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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
            VehicleBrand::create([
                'name' => ucfirst(strtolower($request->name))
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
            // 🔥 Cegah hapus kalau masih dipakai
            if ($vehicleBrand->vehicles()->count() > 0) {
                return back()->with(
                    'error',
                    'Brand kendaraan tidak bisa dihapus karena masih digunakan.'
                );
            }

            $vehicleBrand->delete();

            return back()->with('success', 'Brand kendaraan berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('VehicleBrand delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus brand kendaraan.');
        }
    }
}