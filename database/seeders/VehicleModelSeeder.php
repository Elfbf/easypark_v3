<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            'Honda' => [
                'Beat',
                'Vario',
                'PCX',
                'Scoopy',
                'Brio',
                'HR-V',
                'CR-V',
            ],

            'Yamaha' => [
                'NMAX',
                'Aerox',
                'Mio',
                'Fazzio',
            ],

            'Suzuki' => [
                'Satria',
                'Nex',
                'Ertiga',
                'XL7',
            ],

            'Kawasaki' => [
                'Ninja',
                'KLX',
                'W175',
            ],

            'Toyota' => [
                'Avanza',
                'Innova',
                'Rush',
                'Fortuner',
                'Agya',
            ],

            'Daihatsu' => [
                'Xenia',
                'Ayla',
                'Terios',
                'Sigra',
            ],

            'Mitsubishi' => [
                'Xpander',
                'Pajero',
                'L300',
            ],

            'Nissan' => [
                'Livina',
                'Magnite',
            ],

            'Wuling' => [
                'Air EV',
                'Alvez',
                'Confero',
            ],
        ];

        foreach ($models as $brandName => $vehicleModels) {

            $brand = VehicleBrand::where('name', $brandName)->first();

            if (!$brand) {
                continue;
            }

            foreach ($vehicleModels as $modelName) {

                VehicleModel::firstOrCreate([
                    'vehicle_brand_id' => $brand->id,
                    'name' => $modelName,
                ]);
            }
        }
    }
}