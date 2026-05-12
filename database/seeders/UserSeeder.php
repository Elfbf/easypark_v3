<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\StudyProgram;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            // ADMIN
            // test
            [
                'role' => 'admin',
                'name' => 'Admin EasyPark',
                'email' => 'admin@easypark.com',
                'nim_nip' => null,
                'department' => null,
                'study_program' => null,
            ],

            // PETUGAS
            [+
                'role' => 'petugas',
                'name' => 'Petugas Parkir',
                'email' => 'petugas@easypark.com',
                'nim_nip' => '198765432109876543',
                'department' => null,
                'study_program' => null,
            ],

            // MAHASISWA
            [
                'role' => 'mahasiswa',
                'name' => 'Alief Chandra D',
                'email' => 'elfbfchan@gmail.com',
                'nim_nip' => 'E41230869',
                'department' => 'Teknologi Informasi',
                'study_program' => 'Teknik Informatika',
            ],
        ];

        foreach ($users as $data) {

            $role = Role::firstWhere('name', $data['role']);

            $department = $data['department']
                ? Department::firstWhere('name', $data['department'])
                : null;

            $studyProgram = $data['study_program']
                ? StudyProgram::firstWhere('name', $data['study_program'])
                : null;

            User::firstOrCreate(
                [
                    'email' => $data['email'],
                ],
                [
                    'role_id' => $role?->id,
                    'name' => $data['name'],
                    'nim_nip' => $data['nim_nip'],

                    'department_id' => $department?->id,
                    'study_program_id' => $studyProgram?->id,

                    'is_active' => true,
                    'email_verified_at' => now(),

                    // password otomatis dari NIM/NIP
                    'password' => Hash::make(
                        $data['nim_nip'] ?? 'admin123'
                    ),
                ]
            );
        }
    }
}
