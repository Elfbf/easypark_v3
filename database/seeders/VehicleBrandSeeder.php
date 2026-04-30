<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;
use Carbon\Carbon;

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

            $createdAt = Carbon::now()->subDays(rand(1, 30));
            $updatedAt = Carbon::now();

            VehicleBrand::firstOrCreate(
                ['name' => $brand],
                [
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]
            );
        }
    }
}