<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'petugas', 'mahasiswa'];

        foreach ($roles as $role) {

            $createdAt = Carbon::now()->subDays(rand(1, 30));
            $updatedAt = Carbon::now();

            Role::firstOrCreate(
                ['name' => $role],
                [
                    'name' => $role,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]
            );
        }
    }
}