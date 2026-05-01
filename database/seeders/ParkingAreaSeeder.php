<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingArea;

class ParkingAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            // AREA MOBIL
            [
                'name'        => 'Parkir Mobil A',
                'code'        => 'MBL-A',
                'description' => 'Area parkir mobil A',
                'capacity'    => 6,
            ],

            // AREA MOTOR
            [
                'name'        => 'Parkir Motor A',
                'code'        => 'MTR-A',
                'description' => 'Area parkir motor A',
                'capacity'    => 4,
            ],
            [
                'name'        => 'Parkir Motor B',
                'code'        => 'MTR-B',
                'description' => 'Area parkir motor B',
                'capacity'    => 4,
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