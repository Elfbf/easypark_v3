<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class StudyProgramController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $studyPrograms = StudyProgram::with('department')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.study-programs.index', compact('studyPrograms'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.study-programs.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
        ]);

        try {
            StudyProgram::create([
                'department_id' => $request->department_id,
                'name' => $request->name,
            ]);

            return redirect()->route('admin.study-programs.index')
                ->with('success', 'Program studi berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('StudyProgram store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan program studi.');
        }
    }

    public function show(StudyProgram $studyProgram)
    {
        return view('admin.study-programs.show', compact('studyProgram'));
    }

    public function edit(StudyProgram $studyProgram)
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.study-programs.edit', compact(
            'studyProgram',
            'departments'
        ));
    }

    public function update(Request $request, StudyProgram $studyProgram)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
        ]);

        try {
            $studyProgram->update([
                'department_id' => $request->department_id,
                'name' => $request->name,
            ]);

            return redirect()->route('admin.study-programs.index')
                ->with('success', 'Program studi berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('StudyProgram update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui program studi.');
        }
    }

    public function destroy(StudyProgram $studyProgram)
    {
        try {
            $studyProgram->delete();

            return redirect()->route('admin.study-programs.index')
                ->with('success', 'Program studi berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('StudyProgram delete failed: ' . $e->getMessage());

            return back()
                ->with('error', 'Gagal menghapus program studi.');
        }
    }
}
