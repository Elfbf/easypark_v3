<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingArea;
use App\Models\ParkingSlot;
use App\Models\VehicleType;
use Carbon\Carbon;

class ParkingSlotSeeder extends Seeder
{
    public function run(): void
    {
        $motor = VehicleType::where('name', 'motor')->first();
        $mobil = VehicleType::where('name', 'mobil')->first();

        $areas = ParkingArea::all();

        foreach ($areas as $area) {

            /*
            |--------------------------------------------------------------------------
            | SLOT MOTOR
            |--------------------------------------------------------------------------
            */

            for ($i = 1; $i <= 10; $i++) {

                $createdAt = Carbon::now()->subDays(rand(1, 30));
                $updatedAt = Carbon::now();

                ParkingSlot::firstOrCreate(
                    [
                        'parking_area_id' => $area->id,
                        'slot_code'       => 'M-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    ],
                    [
                        'vehicle_type_id' => $motor?->id,
                        'status'          => 'available',
                        'is_active'       => true,
                        'created_at'      => $createdAt,
                        'updated_at'      => $updatedAt,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | SLOT MOBIL
            |--------------------------------------------------------------------------
            */

            for ($i = 1; $i <= 5; $i++) {

                $createdAt = Carbon::now()->subDays(rand(1, 30));
                $updatedAt = Carbon::now();

                ParkingSlot::firstOrCreate(
                    [
                        'parking_area_id' => $area->id,
                        'slot_code'       => 'C-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    ],
                    [
                        'vehicle_type_id' => $mobil?->id,
                        'status'          => 'available',
                        'is_active'       => true,
                        'created_at'      => $createdAt,
                        'updated_at'      => $updatedAt,
                    ]
                );
            }
        }
    }
}