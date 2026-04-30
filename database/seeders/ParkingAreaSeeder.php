<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingArea;

class ParkingAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            [
                'name'        => 'Parkir Gedung TI',
                'code'        => 'TI-A',
                'description' => 'Area parkir mahasiswa jurusan Teknologi Informasi',
                'capacity'    => 50,
            ],
            [
                'name'        => 'Parkir Gedung Pertanian',
                'code'        => 'TP-A',
                'description' => 'Area parkir jurusan Produksi Pertanian',
                'capacity'    => 40,
            ],
            [
                'name'        => 'Parkir Gedung Teknik',
                'code'        => 'TK-A',
                'description' => 'Area parkir jurusan Teknik',
                'capacity'    => 35,
            ],
            [
                'name'        => 'Parkir Dosen',
                'code'        => 'DSN',
                'description' => 'Area khusus dosen dan staff',
                'capacity'    => 25,
            ],
        ];

        foreach ($areas as $area) {

            ParkingArea::firstOrCreate(
                [
                    'code' => $area['code'],
                ],
                [
                    'name'        => $area['name'],
                    'description' => $area['description'],
                    'capacity'    => $area['capacity'],
                    'is_active'   => true,
                ]
            );
        }
    }
}