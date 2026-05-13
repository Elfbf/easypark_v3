<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $departments = Department::when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.departments.index', compact('departments', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        try {

            Department::create([
                'name' => $request->name
            ]);

            return back()->with('success', 'Jurusan berhasil ditambahkan.');

        } catch (QueryException $e) {

            Log::error('Department store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan jurusan.');
        }
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

        try {

            $department->update([
                'name' => $request->name
            ]);

            return back()->with('success', 'Jurusan berhasil diperbarui.');

        } catch (QueryException $e) {

            Log::error('Department update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui jurusan.');
        }
    }

    public function destroy(Department $department)
    {
        try {

            if ($department->studyPrograms()->count() > 0) {
                return back()->with(
                    'error',
                    'Jurusan tidak bisa dihapus karena masih memiliki program studi.'
                );
            }

            if ($department->users()->count() > 0) {
                return back()->with(
                    'error',
                    'Jurusan tidak bisa dihapus karena masih digunakan user.'
                );
            }

            $department->delete();

            return back()->with('success', 'Jurusan berhasil dihapus.');

        } catch (QueryException $e) {

            Log::error('Department delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus jurusan.');
        }
    }
}