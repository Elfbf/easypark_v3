<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\VehicleType;
use App\Models\VehicleBrand;
use Carbon\Carbon;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'user_email'   => 'elfbfchan@easypark.com',
                'type'         => 'motor',
                'brand'        => 'Honda',
                'plate_number' => 'P 1234 ABC',
                'color'        => 'Hitam',
                'is_parked'    => false,
            ],
            [
                'user_email'   => 'elfbfchan@easypark.com',
                'type'         => 'motor',
                'brand'        => 'Yamaha',
                'plate_number' => 'P 5678 XYZ',
                'color'        => 'Merah',
                'is_parked'    => false,
            ]
        ];

        foreach ($vehicles as $data) {

            // 🔥 Ambil user (boleh null untuk tamu)
            $user = $data['user_email']
                ? User::where('email', $data['user_email'])->first()
                : null;

            // 🔥 Ambil type
            $type = VehicleType::firstWhere('name', $data['type']);

            // 🔥 Ambil brand
            $brand = VehicleBrand::firstWhere('name', $data['brand']);

            if (!$type || !$brand) {
                $this->command?->warn("Type/Brand tidak ditemukan: {$data['type']} - {$data['brand']}");
                continue;
            }

            // ⏰ timestamp random
            $createdAt = Carbon::now()->subDays(rand(1, 30));
            $updatedAt = Carbon::now();

            Vehicle::firstOrCreate(
                ['plate_number' => $data['plate_number']], // unik
                [
                    'user_id'          => $user?->id,
                    'vehicle_type_id'  => $type->id,
                    'vehicle_brand_id' => $brand->id,
                    'color'            => $data['color'],
                    'vehicle_photo'    => null,
                    'stnk_photo'       => null,
                    'is_parked'        => $data['is_parked'] ?? false,
                    'parked_at'        => $data['parked_at'] ?? null,
                    'is_active'        => true,

                    // ⏰ timestamp manual
                    'created_at'       => $createdAt,
                    'updated_at'       => $updatedAt,
                ]
            );
        }
    }
}