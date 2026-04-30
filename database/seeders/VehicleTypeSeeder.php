<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;
use Carbon\Carbon;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'motor',
            'mobil',
        ];

        foreach ($types as $type) {

            $createdAt = Carbon::now()->subDays(rand(1, 30));
            $updatedAt = Carbon::now();

            VehicleType::firstOrCreate(
                ['name' => $type],
                [
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]
            );
        }
    }
}