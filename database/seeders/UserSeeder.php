<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\StudyProgram;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'role' => 'admin',
                'name' => 'Admin EasyPark',
                'email' => 'admin@easypark.com',
                'phone' => '081234567890',
                'nim_nip' => null,
                'department' => null,
                'study_program' => null,
            ],
            [
                'role' => 'petugas',
                'name' => 'Petugas Parkir',
                'email' => 'petugas@easypark.com',
                'phone' => '081234567891',
                'nim_nip' => '123456789012345678',
                'department' => null,
                'study_program' => null,
            ],
            [
                'role' => 'mahasiswa',
                'name' => 'Alief Chandra D',
                'email' => 'elfbfchan@easypark.com',
                'phone' => '081234567892',
                'nim_nip' => 'E20251234',
                'department' => 'Teknologi Informasi',
                'study_program' => 'Teknik Informatika',
            ],
        ];

        foreach ($users as $data) {

            // 🔐 Ambil role
            $role = Role::firstWhere('name', $data['role']);

            // 🎓 Ambil jurusan
            $department = $data['department']
                ? Department::firstWhere('name', $data['department'])
                : null;

            // 📘 Ambil prodi
            $studyProgram = $data['study_program']
                ? StudyProgram::firstWhere('name', $data['study_program'])
                : null;

            if (!$role) {
                $this->command?->warn("Role tidak ditemukan: {$data['role']}");
                continue;
            }

            // ⏰ waktu random biar realistis
            $createdAt = Carbon::now()->subDays(rand(1, 30));
            $updatedAt = Carbon::now();

            User::firstOrCreate(
                ['email' => $data['email']], // unik
                [
                    'role_id' => $role->id,
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'nim_nip' => $data['nim_nip'],
                    'department_id' => $department?->id,
                    'study_program_id' => $studyProgram?->id,
                    'is_active' => true,
                    'password' => Hash::make('password'),

                    // ⏰ timestamp manual
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]
            );
        }
    }
}