<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyProgram;
use App\Models\Department;

class StudyProgramSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Produksi Pertanian' => [
                'Produksi Tanaman Hortikultura',
                'Produksi Tanaman Perkenbunan',
                'Teknik Produksi Benih',
                'Teknologi Produksi Tanaman Pangan',
                'Budidaya Tanaman Perkebunan',
                'Pengelolaan Perkebunan Kopi',
            ],
            'Teknologi Pertanian' => [
                'Keteknikan Pertanian',
                'Teknologi Industri Pangan',
                'Teknologi Rekayasa Pangan',
                'Teknologi Rekayasa Pengemasan',
            ],
            'Peternakan' => [
                'Produksi Ternak',
                'Manajemen Bisnis Unggas',
                'Teknologi Pangan Ternak',
            ],
            'Manajemen Agribinis' => [
                'Manajemen Agribinis',
                'Manajemen Agroinbinis',
                'Pascasarjana Agribinis',
            ],
            'Teknologi Informasi' => [
                'Manajemen Informatika',
                'Teknik Komputer',
                'Teknik Informatika',
                'Teknologi Rekayasa Komputer',
            ],
            'Bahasa, Komunikasi dan Pariwisata' => [
                'Bahasa Inggris',
                'Destinasi Pariwisata',
                'Produksi Media',
            ],
            'Kesehatan' => [
                'Manajemen Informasi Kesehatan',
                'Gizi Klinik',
                'Promosi Kesehatan',
            ],
            'Teknik' => [
                'Teknik Energi Terbarukan',
                'Teknik Otomotif',
                'Teknik Rekayasa Mekatronika',
            ],
            'Bisnis' => [
                'Akuntansi Sektor Publik',
                'Bisnis Digital',
                'Manajemen Pemasaran Internasional',
            ],
        ];

        foreach ($data as $departmentName => $programs) {
            $department = Department::where('name', $departmentName)->first();

            if (!$department) continue; // biar aman kalau tidak ditemukan

            foreach ($programs as $program) {
                StudyProgram::create([
                    'department_id' => $department->id,
                    'name' => $program,
                ]);
            }
        }
    }
}
