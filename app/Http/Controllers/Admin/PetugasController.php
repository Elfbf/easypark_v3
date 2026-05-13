<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('nim_nip', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.petugas.index', compact('petugas', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'nim_nip'    => 'required|string|max:255|unique:users,nim_nip',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|unique:users,email',
            'password'   => 'required|string|min:6',
            'gender'     => 'nullable|in:L,P',
            'birth_date' => 'nullable|date',
            'address'    => 'nullable|string|max:500',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {

            $role = Role::where('name', 'petugas')->firstOrFail();

            $photoPath = null;

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos/petugas', 'public');
            }

            User::create([
                'role_id'    => $role->id,
                'name'       => $request->name,
                'nim_nip'    => $request->nim_nip,
                'phone'      => $request->phone,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'is_active'  => $request->boolean('is_active'),
                'gender'     => $request->gender,
                'birth_date' => $request->birth_date,
                'address'    => $request->address,
                'photo'      => $photoPath,
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
            'name'       => 'required|string|max:255',
            'nim_nip'    => 'required|string|max:255|unique:users,nim_nip,' . $petugas->id,
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|unique:users,email,' . $petugas->id,
            'gender'     => 'nullable|in:L,P',
            'birth_date' => 'nullable|date',
            'address'    => 'nullable|string|max:500',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {

            $data = [
                'name'       => $request->name,
                'nim_nip'    => $request->nim_nip,
                'phone'      => $request->phone,
                'email'      => $request->email,
                'is_active'  => $request->boolean('is_active'),
                'gender'     => $request->gender,
                'birth_date' => $request->birth_date,
                'address'    => $request->address,
            ];

            if ($request->hasFile('photo')) {

                if ($petugas->photo) {
                    Storage::disk('public')->delete($petugas->photo);
                }

                $data['photo'] = $request->file('photo')->store('photos/petugas', 'public');
            }

            $petugas->update($data);

            return back()->with('success', 'Data petugas berhasil diperbarui.');

        } catch (QueryException $e) {

            Log::error('Petugas update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui petugas.');
        }
    }

    public function show(User $petugas)
    {
        return response()->json($petugas);
    }

    public function destroy(User $petugas)
    {
        try {

            if ($petugas->photo) {
                Storage::disk('public')->delete($petugas->photo);
            }

            $petugas->delete();

            return back()->with('success', 'Data petugas berhasil dihapus.');

        } catch (QueryException $e) {

            Log::error('Petugas delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus petugas.');
        }
    }
}