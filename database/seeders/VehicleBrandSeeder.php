<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;

class VehicleBrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            // 🔥 Motor
            'Honda',
            'Yamaha',
            'Suzuki',
            'Kawasaki',

            // 🔥 Mobil
            'Toyota',
            'Daihatsu',
            'Mitsubishi',
            'Honda',
            'Nissan',
            'Wuling',
        ];

        foreach ($brands as $brand) {

            VehicleBrand::firstOrCreate([
                'name' => $brand,
            ]);
        }
    }
}