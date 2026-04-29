<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $petugas = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('name', 'petugas');
            })
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nim_nip', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.petugas.index', compact('petugas', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'nim_nip'   => 'required|string|max:255|unique:users,nim_nip',
            'phone'     => 'nullable|string|max:20',
            'email'     => 'nullable|email|unique:users,email',
            'password'  => 'required|string|min:6',
        ]);

        try {
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

            return back()->with('success', 'Data petugas berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('Petugas store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan petugas.');
        }
    }

    public function update(Request $request, User $petugas)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'nim_nip'   => 'required|string|max:255|unique:users,nim_nip,' . $petugas->id,
            'phone'     => 'nullable|string|max:20',
            'email'     => 'nullable|email|unique:users,email,' . $petugas->id,
        ]);

        try {
            $petugas->update([
                'name'      => $request->name,
                'nim_nip'   => $request->nim_nip,
                'phone'     => $request->phone,
                'email'     => $request->email,
                'is_active' => $request->boolean('is_active'),
            ]);

            return back()->with('success', 'Data petugas berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Petugas update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui petugas.');
        }
    }

    public function destroy(User $petugas)
    {
        try {
            $petugas->delete();

            return back()->with('success', 'Data petugas berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('Petugas delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus petugas.');
        }
    }
}