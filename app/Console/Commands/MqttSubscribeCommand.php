<?php

namespace App\Console\Commands;

use App\Models\ParkingRecord;
use App\Models\Vehicle;
use App\Services\MqttService;
use Illuminate\Console\Command;

class MqttSubscribeCommand extends Command
{
    protected $signature = 'mqtt:subscribe';

    protected $description = 'MQTT Smart Parking Subscriber';

    public function __construct(
        private MqttService $mqtt
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('🚀 MQTT Subscriber Aktif');

        $this->mqtt->subscribeMultiple([

            // =========================================================
            // GATE ENTRY
            // =========================================================

            'gate/entry' => function ($topic, $message) {

                $this->line("\n📥 ENTRY MESSAGE:");
                $this->line($message);

                $data = json_decode($message, true);

                if (!$data) {

                    $this->error('❌ Payload JSON tidak valid');

                    return;
                }

                $plate = strtoupper(
                    trim($data['plate_number'] ?? '')
                );

                if (!$plate) {

                    $this->error('❌ Plate number kosong');

                    return;
                }

                // =====================================================
                // VALIDASI KENDARAAN
                // =====================================================

                $vehicle = Vehicle::where(
                    'plate_number',
                    $plate
                )->first();

                if (!$vehicle) {

                    $this->mqtt->publish('gate/response', [
                        'status'  => 'DENIED',
                        'message' => 'Kendaraan tidak terdaftar',
                    ]);

                    $this->error("❌ Kendaraan $plate tidak terdaftar");

                    return;
                }

                // =====================================================
                // CEK MASIH PARKIR
                // =====================================================

                $active = ParkingRecord::where(
                    'plate_number',
                    $plate
                )
                ->where('status', 'parked')
                ->first();

                if ($active) {

                    $this->mqtt->publish('gate/response', [
                        'status'  => 'DENIED',
                        'message' => 'Kendaraan masih parkir',
                    ]);

                    $this->warn("⚠ $plate masih berada di area parkir");

                    return;
                }

                // =====================================================
                // SIMPAN RECORD MASUK
                // =====================================================

                ParkingRecord::create([

                    'vehicle_id'   => $vehicle->id,

                    'plate_number' => $plate,

                    'entry_time'   => now(),

                    'status'       => 'parked',
                ]);

                // =====================================================
                // OPEN GATE
                // =====================================================

                $this->mqtt->publish('gate/response', [

                    'status'       => 'OPEN_GATE',

                    'gate'         => 'ENTRY',

                    'plate_number' => $plate,
                ]);

                $this->info("✅ Gerbang masuk dibuka untuk $plate");
            },

            // =========================================================
            // GATE EXIT
            // =========================================================

            'gate/exit' => function ($topic, $message) {

                $this->line("\n📤 EXIT MESSAGE:");
                $this->line($message);

                $data = json_decode($message, true);

                if (!$data) {

                    $this->error('❌ Payload JSON tidak valid');

                    return;
                }

                $plate = strtoupper(
                    trim($data['plate_number'] ?? '')
                );

                if (!$plate) {

                    $this->error('❌ Plate number kosong');

                    return;
                }

                // =====================================================
                // CARI PARKING AKTIF
                // =====================================================

                $parking = ParkingRecord::where(
                    'plate_number',
                    $plate
                )
                ->where('status', 'parked')
                ->latest()
                ->first();

                if (!$parking) {

                    $this->mqtt->publish('gate/response', [

                        'status'  => 'DENIED',

                        'message' => 'Data parkir tidak ditemukan',
                    ]);

                    $this->warn("⚠ Parking aktif $plate tidak ditemukan");

                    return;
                }

                // =====================================================
                // UPDATE EXIT
                // =====================================================

                $parking->update([

                    'exit_time' => now(),

                    'status'    => 'completed', // ✅ sesuai ENUM di database
                ]);

                // =====================================================
                // OPEN GATE EXIT
                // =====================================================

                $this->mqtt->publish('gate/response', [

                    'status'       => 'OPEN_GATE',

                    'gate'         => 'EXIT',

                    'plate_number' => $plate,
                ]);

                $this->info("✅ Gerbang keluar dibuka untuk $plate");
            },

        ]);
    }
}