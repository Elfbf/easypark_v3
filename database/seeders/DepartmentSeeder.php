<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Produksi Pertanian',
            'Teknologi Pertanian',
            'Peternakan',
            'Manajemen Agribisnis',
            'Teknologi Informasi',
            'Bahasa, Komunikasi dan Pariwisata',
            'Kesehatan',
            'Teknik',
            'Bisnis',
        ];

        foreach ($departments as $department) {

            $createdAt = Carbon::now()->subDays(rand(1, 30));
            $updatedAt = Carbon::now();

            Department::firstOrCreate(
                ['name' => $department],
                [
                    'name' => $department,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]
            );
        }
    }
}