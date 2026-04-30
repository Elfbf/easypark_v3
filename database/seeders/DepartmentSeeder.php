<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

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
            Department::firstOrCreate([
                'name' => $department,
            ]);
        }
    }
}