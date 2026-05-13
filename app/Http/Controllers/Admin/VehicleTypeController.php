<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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

            VehicleType::create([
                'name' => strtolower($request->name)
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

            $vehicleType->delete();

            return back()->with('success', 'Tipe kendaraan berhasil dihapus.');

        } catch (QueryException $e) {

            Log::error('VehicleType delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus tipe kendaraan.');
        }
    }
}