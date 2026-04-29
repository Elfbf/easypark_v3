<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Role;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = User::with([
                'role',
                'department',
                'studyProgram',
            ])
            ->whereHas('role', function ($query) {
                $query->where('name', 'mahasiswa');
            })
            ->latest()
            ->paginate(10);

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();

        $studyPrograms = StudyProgram::with('department')
            ->orderBy('name')
            ->get();

        return view('admin.mahasiswa.create', compact(
            'departments',
            'studyPrograms'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'nim_nip'           => 'required|string|max:255|unique:users,nim_nip',
            'email'             => 'nullable|email|unique:users,email',
            'phone'             => 'nullable|string|max:20',
            'gender'            => 'nullable|in:L,P',
            'birth_date'        => 'nullable|date',
            'address'           => 'nullable|string',
            'department_id'     => 'nullable|exists:departments,id',
            'study_program_id'  => 'nullable|exists:study_programs,id',
            'password'          => 'required|string|min:6',
        ]);

        $role = Role::where('name', 'mahasiswa')->firstOrFail();

        User::create([
            'role_id'           => $role->id,
            'name'              => $request->name,
            'nim_nip'           => $request->nim_nip,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'gender'            => $request->gender,
            'birth_date'        => $request->birth_date,
            'address'           => $request->address,
            'department_id'     => $request->department_id,
            'study_program_id'  => $request->study_program_id,
            'password'          => Hash::make($request->password),
            'is_active'         => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $mahasiswa)
    {
        $departments = Department::orderBy('name')->get();

        $studyPrograms = StudyProgram::with('department')
            ->orderBy('name')
            ->get();

        return view('admin.mahasiswa.edit', compact(
            'mahasiswa',
            'departments',
            'studyPrograms'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $mahasiswa)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'nim_nip'           => 'required|string|max:255|unique:users,nim_nip,' . $mahasiswa->id,
            'email'             => 'nullable|email|unique:users,email,' . $mahasiswa->id,
            'phone'             => 'nullable|string|max:20',
            'gender'            => 'nullable|in:L,P',
            'birth_date'        => 'nullable|date',
            'address'           => 'nullable|string',
            'department_id'     => 'nullable|exists:departments,id',
            'study_program_id'  => 'nullable|exists:study_programs,id',
        ]);

        $mahasiswa->update([
            'name'              => $request->name,
            'nim_nip'           => $request->nim_nip,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'gender'            => $request->gender,
            'birth_date'        => $request->birth_date,
            'address'           => $request->address,
            'department_id'     => $request->department_id,
            'study_program_id'  => $request->study_program_id,
            'is_active'         => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}