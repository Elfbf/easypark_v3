<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
            $department = Department::create([
                'name' => $request->name
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Department',
                'activity' => 'create_department',
                'description' => 'Menambahkan jurusan ' . $department->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
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

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Department',
                'activity' => 'update_department',
                'description' => 'Memperbarui jurusan ' . $department->name,
                'ip_address' => Request()->ip(),
                'user_agent' => Request()->userAgent(),
                'url' => Request()->url(),
                'method' => Request()->method(),
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

            $departmentName = $department->name;

            $department->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Department',
                'activity' => 'delete_department',
                'description' => 'Menghapus jurusan ' . $departmentName,
                'ip_address' => Request()->ip(),
                'user_agent' => Request()->userAgent(),
                'url' => Request()->url(),
                'method' => Request()->method(),
            ]);

            return back()->with('success', 'Jurusan berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('Department delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus jurusan.');
        }
    }
}