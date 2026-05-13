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

// ✅ FIX: mqtt:subscribe DIHAPUS dari scheduler.
// Proses ini dijaga oleh Supervisor agar selalu hidup & auto-restart jika crash.
// Jalankan setup Supervisor sekali di server:
//
//   sudo nano /etc/supervisor/conf.d/easypark-mqtt.conf
//
//   [program:easypark-mqtt]
//   command=php /var/www/html/artisan mqtt:subscribe
//   directory=/var/www/html
//   autostart=true
//   autorestart=true
//   stderr_logfile=/var/log/easypark-mqtt.err.log
//   stdout_logfile=/var/log/easypark-mqtt.out.log
//   user=www-data
//   stopwaitsecs=10
//
//   sudo supervisorctl reread
//   sudo supervisorctl update
//   sudo supervisorctl start easypark-mqtt
//
// Cek status: sudo supervisorctl status easypark-mqtt