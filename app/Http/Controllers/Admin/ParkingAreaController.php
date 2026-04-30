<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ParkingAreaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $parkingAreas = ParkingArea::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.parking-areas.index', compact(
            'parkingAreas',
            'search'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:parking_areas,code',
            'description' => 'nullable|string',
            'capacity'    => 'required|integer|min:0',
        ]);

        try {
            ParkingArea::create([
                'name'        => $request->name,
                'code'        => strtoupper($request->code),
                'description' => $request->description,
                'capacity'    => $request->capacity,
                'is_active'   => true,
            ]);

            return back()->with(
                'success',
                'Area parkir berhasil ditambahkan.'
            );

        } catch (QueryException $e) {

            Log::error('ParkingArea store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan area parkir.');
        }
    }

    public function update(Request $request, ParkingArea $parkingArea)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:parking_areas,code,' . $parkingArea->id,
            'description' => 'nullable|string',
            'capacity'    => 'required|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        try {

            $parkingArea->update([
                'name'        => $request->name,
                'code'        => strtoupper($request->code),
                'description' => $request->description,
                'capacity'    => $request->capacity,
                'is_active'   => $request->boolean('is_active'),
            ]);

            return back()->with(
                'success',
                'Area parkir berhasil diperbarui.'
            );

        } catch (QueryException $e) {

            Log::error('ParkingArea update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui area parkir.');
        }
    }

    public function destroy(ParkingArea $parkingArea)
    {
        try {

            if ($parkingArea->parkingSlots()->count() > 0) {
                return back()->with(
                    'error',
                    'Area parkir tidak bisa dihapus karena masih memiliki slot parkir.'
                );
            }

            $parkingArea->delete();

            return back()->with(
                'success',
                'Area parkir berhasil dihapus.'
            );

        } catch (QueryException $e) {

            Log::error('ParkingArea delete failed: ' . $e->getMessage());

            return back()->with(
                'error',
                'Gagal menghapus area parkir.'
            );
        }
    }
}