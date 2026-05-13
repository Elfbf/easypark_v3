<?php

namespace App\Console\Commands;

use App\Services\MqttService;
use App\Services\ParkingSlotService;
use Illuminate\Console\Command;

class MqttSubscribeCommand extends Command
{
    protected $signature   = 'mqtt:subscribe';
    protected $description = 'Subscribe ke topic MQTT sensor smart parking';

    public function __construct(
        private MqttService        $mqtt,
        //private ParkingSlotService $parkingSlot
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('🚀 MQTT subscriber aktif — mendengarkan sensor parkir...');
        $this->info('   Topic: ' . env('MQTT_TOPIC_PREFIX') . 'slot/+');
        $this->info('   Tekan Ctrl+C untuk berhenti.' . PHP_EOL);

        $this->mqtt->subscribe('slot/+', function (string $topic, string $message) {

            $data   = json_decode($message, true);
            $slotId = $data['slot_id'] ?? null;
            $status = $data['status']  ?? null; // 'occupied' | 'available'

            // Tampilkan di terminal
            $this->line(sprintf(
                '[%s] Topic: <comment>%s</comment> | Slot: <info>%s</info> | Status: <info>%s</info>',
                now()->format('H:i:s'),
                $topic,
                $slotId ?? '-',
                $status  ?? '-',
            ));

            // Validasi payload
            if (!$slotId || !in_array($status, ['occupied', 'available'])) {
                $this->warn('   ⚠ Payload tidak valid, dilewati.');
                return;
            }

            // Update ke database
            //$success = $this->parkingSlot->updateStatusFromMqtt($data);

            //if ($success) {
                $this->info('   ✔ Database diperbarui.');
            // } else {
            //     $this->error('   ✘ Gagal update database.');
            // }
        });
    }
}