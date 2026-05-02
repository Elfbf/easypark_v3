<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;
use Illuminate\Http\Request;

class ParkingAreaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $parkingAreas = ParkingArea::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        })
            ->where('is_active', true)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('petugas.parking-areas.index', compact(
            'parkingAreas',
            'search'
        ));
    }

    public function show(ParkingArea $parkingArea)
    {
        abort_if(! $parkingArea->is_active, 403);

        return view('petugas.parking-areas.show', compact('parkingArea'));
    }
}
