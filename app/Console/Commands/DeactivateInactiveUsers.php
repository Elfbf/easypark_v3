<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeactivateInactiveUsers extends Command
{
    protected $signature = 'users:deactivate-inactive';

    protected $description = 'Nonaktifkan user yang tidak login selama 1 bulan';

    public function handle(): void
    {
        $users = User::where('is_active', true)->get();

        foreach ($users as $user) {

            if (
                $user->last_login_at &&
                $user->last_login_at->lt(now()->subMonth())
            ) {
                $user->update([
                    'is_active' => false
                ]);
            }
        }

        $this->info('User inactive berhasil dinonaktifkan.');
    }
}