<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'motor',
            'mobil',
        ];

        foreach ($types as $type) {

            VehicleType::firstOrCreate([
                'name' => $type,
            ]);
        }
    }
}