<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::insert([
            ['name' => 'Produksi Pertanian'],
            ['name' => 'Teknologi Pertanian'],
            ['name' => 'Peternakan'],
            ['name' => 'Manajemen Agribinis'],
            ['name' => 'Teknologi Informasi'],
            ['name' => 'Bahasa, Komunikasi dan Pariwisata'],
            ['name' => 'Kesehatan'],
            ['name' => 'Teknik'],
            ['name' => 'Bisnis'],
        ]);
    }
}