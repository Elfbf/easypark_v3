<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/*
|--------------------------------------------------------------------------
| Scheduler
|--------------------------------------------------------------------------
*/

// Nonaktifkan user yang tidak login selama 1 bulan
Schedule::command('users:deactivate-inactive')
    ->everyMinute();

// MQTT subscriber — dijaga Supervisor di production, cukup dijalankan manual di local
// php artisan mqtt:subscribe
Schedule::command('mqtt:subscribe')
    ->everyMinute()
    ->withoutOverlapping()   // pastikan tidak jalan dobel
    ->runInBackground();     // tidak block scheduler lain