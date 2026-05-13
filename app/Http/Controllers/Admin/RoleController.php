<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $roles = Role::when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.roles.index', compact('roles', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        try {

            Role::create([
                'name' => Str::lower($request->name)
            ]);

            return back()->with('success', 'Role berhasil ditambahkan.');

        } catch (QueryException $e) {

            Log::error('Role store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan role.');
        }
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        try {

            $role->update([
                'name' => Str::lower($request->name)
            ]);

            return back()->with('success', 'Role berhasil diperbarui.');

        } catch (QueryException $e) {

            Log::error('Role update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui role.');
        }
    }

    public function destroy(Role $role)
    {
        try {

            if ($role->users()->count() > 0) {
                return back()->with(
                    'error',
                    'Role tidak bisa dihapus karena masih digunakan.'
                );
            }

            $role->delete();

            return back()->with('success', 'Role berhasil dihapus.');

        } catch (QueryException $e) {

            Log::error('Role delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus role.');
        }
    }
}