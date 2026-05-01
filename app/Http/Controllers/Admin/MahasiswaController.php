<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $mahasiswa = User::with(['role', 'department', 'studyProgram'])
            ->whereHas('role', function ($query) {
                $query->where('name', 'mahasiswa');
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

        $departments = Department::orderBy('name')->get();
        $studyPrograms = StudyProgram::orderBy('name')->get();

        return view('admin.mahasiswa.index', compact(
            'mahasiswa',
            'departments',
            'studyPrograms',
            'search'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'nim_nip'          => 'required|string|max:255|unique:users,nim_nip',
            'phone'            => 'nullable|string|max:20',
            'email'            => 'nullable|email|unique:users,email',
            'password'         => 'required|string|min:6',
            'department_id'    => 'required|exists:departments,id',
            'study_program_id' => 'required|exists:study_programs,id',
            'gender'           => 'nullable|in:L,P',
            'birth_date'       => 'nullable|date',
            'address'          => 'nullable|string|max:500',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $role = Role::where('name', 'mahasiswa')->firstOrFail();

            $photoPath = null;

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos/mahasiswa', 'public');
            }

            $user = User::create([
                'role_id'          => $role->id,
                'name'             => $request->name,
                'nim_nip'          => $request->nim_nip,
                'phone'            => $request->phone,
                'email'            => $request->email,
                'password'         => Hash::make($request->password),
                'department_id'    => $request->department_id,
                'study_program_id' => $request->study_program_id,
                'is_active'        => $request->boolean('is_active'),
                'gender'           => $request->gender,
                'birth_date'       => $request->birth_date,
                'address'          => $request->address,
                'photo'            => $photoPath,
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Mahasiswa',
                'activity' => 'create_mahasiswa',
                'description' => 'Menambahkan mahasiswa ' . $user->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Data mahasiswa berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('Mahasiswa store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan mahasiswa.');
        }
    }

    public function update(Request $request, User $mahasiswa)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'nim_nip'          => 'required|string|max:255|unique:users,nim_nip,' . $mahasiswa->id,
            'phone'            => 'nullable|string|max:20',
            'email'            => 'nullable|email|unique:users,email,' . $mahasiswa->id,
            'department_id'    => 'required|exists:departments,id',
            'study_program_id' => 'required|exists:study_programs,id',
            'gender'           => 'nullable|in:L,P',
            'birth_date'       => 'nullable|date',
            'address'          => 'nullable|string|max:500',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $data = [
                'name'             => $request->name,
                'nim_nip'          => $request->nim_nip,
                'phone'            => $request->phone,
                'email'            => $request->email,
                'department_id'    => $request->department_id,
                'study_program_id' => $request->study_program_id,
                'is_active'        => $request->boolean('is_active'),
                'gender'           => $request->gender,
                'birth_date'       => $request->birth_date,
                'address'          => $request->address,
            ];

            if ($request->hasFile('photo')) {

                if ($mahasiswa->photo) {
                    Storage::disk('public')->delete($mahasiswa->photo);
                }

                $data['photo'] = $request->file('photo')->store('photos/mahasiswa', 'public');
            }

            $mahasiswa->update($data);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Mahasiswa',
                'activity' => 'update_mahasiswa',
                'description' => 'Memperbarui mahasiswa ' . $mahasiswa->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Mahasiswa update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui mahasiswa.');
        }
    }

    public function show(User $mahasiswa)
    {
        return response()->json($mahasiswa->load(['department', 'studyProgram']));
    }

    public function destroy(User $mahasiswa)
    {
        try {
            if ($mahasiswa->photo) {
                Storage::disk('public')->delete($mahasiswa->photo);
            }

            $mahasiswaName = $mahasiswa->name;

            $mahasiswa->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Mahasiswa',
                'activity' => 'delete_mahasiswa',
                'description' => 'Menghapus mahasiswa ' . $mahasiswaName,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->url(),
                'method' => request()->method(),
            ]);

            return back()->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('Mahasiswa delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus mahasiswa.');
        }
    }
}