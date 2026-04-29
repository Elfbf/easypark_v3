<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugas = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('name', 'petugas');
            })
            ->latest()
            ->paginate(10);

        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.petugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'nim_nip'   => 'required|string|max:255|unique:users,nim_nip',
            'phone'     => 'nullable|string|max:20',
            'email'     => 'nullable|email|unique:users,email',
            'password'  => 'required|string|min:6',
        ]);

        $role = Role::where('name', 'petugas')->firstOrFail();

        User::create([
            'role_id'   => $role->id,
            'name'      => $request->name,
            'nim_nip'   => $request->nim_nip,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $petugas)
    {
        return view('admin.petugas.edit', compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $petugas)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'nim_nip'   => 'required|string|max:255|unique:users,nim_nip,' . $petugas->id,
            'phone'     => 'nullable|string|max:20',
            'email'     => 'nullable|email|unique:users,email,' . $petugas->id,
        ]);

        $petugas->update([
            'name'      => $request->name,
            'nim_nip'   => $request->nim_nip,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $petugas)
    {
        $petugas->delete();

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil dihapus.');
    }
}