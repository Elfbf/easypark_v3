<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class MqttService
{
    protected string $topicPrefix;

    public function __construct()
    {
        $this->topicPrefix = env('MQTT_TOPIC_PREFIX', 'easypark/parking/');
    }

    // -------------------------------------------------------------------------
    // PUBLISH
    // -------------------------------------------------------------------------

    /**
     * Publish pesan ke topic MQTT.
     *
     * Contoh:
     *   $mqtt->publish('slot/A1', ['status' => 'occupied']);
     *   → topic: easypark/parking/slot/A1
     */
    public function publish(string $topic, array $payload, int $qos = 1, bool $retain = false): bool
    {
        try {
            $mqtt = MQTT::connection();

            $mqtt->publish(
                topic:              $this->topicPrefix . $topic,
                message:            json_encode($payload),
                qualityOfService:   $qos,
                retain:             $retain
            );

            $mqtt->disconnect();

            Log::info('[MQTT] Publish berhasil', [
                'topic'   => $this->topicPrefix . $topic,
                'payload' => $payload,
            ]);

            return true;

        } catch (\Throwable $e) {
            Log::error('[MQTT] Publish gagal', [
                'topic'   => $this->topicPrefix . $topic,
                'payload' => $payload,
                'error'   => $e->getMessage(),
            ]);

            return false;
        }
    }

    // -------------------------------------------------------------------------
    // SUBSCRIBE
    // -------------------------------------------------------------------------

    /**
     * Subscribe ke satu topic dan jalankan callback saat ada pesan masuk.
     * Blocking — cocok dipakai di dalam Artisan command.
     *
     * Contoh:
     *   $mqtt->subscribe('slot/+', function (string $topic, string $message) {
     *       $data = json_decode($message, true);
     *       // proses data sensor...
     *   });
     */
    public function subscribe(string $topic, callable $callback): void
    {
        try {
            $mqtt = MQTT::connection();

            $mqtt->subscribe(
                topicFilter:        $this->topicPrefix . $topic,
                callback:           function (string $topic, string $message) use ($callback) {
                    Log::debug('[MQTT] Pesan diterima', [
                        'topic'   => $topic,
                        'message' => $message,
                    ]);

                    $callback($topic, $message);
                },
                qualityOfService:   1
            );

            // Loop blocking — terus berjalan sampai command dihentikan
            $mqtt->loop(allowSleep: true);

        } catch (\Throwable $e) {
            Log::error('[MQTT] Subscribe gagal', [
                'topic' => $this->topicPrefix . $topic,
                'error' => $e->getMessage(),
            ]);
        }
    }

    // -------------------------------------------------------------------------
    // SUBSCRIBE BANYAK TOPIC SEKALIGUS
    // -------------------------------------------------------------------------

    /**
     * Subscribe ke beberapa topic sekaligus dalam satu koneksi.
     *
     * Contoh:
     *   $mqtt->subscribeMultiple([
     *       'slot/+'   => fn($t, $m) => ...,
     *       'gate/+'   => fn($t, $m) => ...,
     *   ]);
     */
    public function subscribeMultiple(array $topicsWithCallbacks): void
    {
        try {
            $mqtt = MQTT::connection();

            foreach ($topicsWithCallbacks as $topic => $callback) {
                $mqtt->subscribe(
                    topicFilter:        $this->topicPrefix . $topic,
                    callback:           function (string $topic, string $message) use ($callback) {
                        Log::debug('[MQTT] Pesan diterima', [
                            'topic'   => $topic,
                            'message' => $message,
                        ]);

                        $callback($topic, $message);
                    },
                    qualityOfService:   1
                );
            }

            $mqtt->loop(allowSleep: true);

        } catch (\Throwable $e) {
            Log::error('[MQTT] Subscribe multiple gagal', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    // -------------------------------------------------------------------------
    // HELPER
    // -------------------------------------------------------------------------

    /**
     * Ambil full topic dengan prefix.
     * Berguna kalau perlu tau topic lengkap di luar service ini.
     */
    public function topic(string $suffix): string
    {
        return $this->topicPrefix . $suffix;
    }
}