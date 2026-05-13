<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class MqttService
{
    protected string $prefix;

    public function __construct()
    {
        $this->prefix = env(
            'MQTT_TOPIC_PREFIX',
            'easypark/parking/'
        );
    }

    // =========================================================
    // PUBLISH
    // =========================================================

    public function publish(
        string $topic,
        array $payload,
        int $qos = 1,
        bool $retain = false
    ): bool {

        try {

            $mqtt = MQTT::connection();

            $fullTopic = $this->prefix . $topic;

            $mqtt->publish(

                topic: $fullTopic,

                message: json_encode($payload),

                qualityOfService: $qos,

                retain: $retain
            );

            // ✅ FIX: flush outgoing buffer dulu sebelum disconnect
            // agar pesan benar-benar terkirim ke broker
            $mqtt->loop(false, true);

            $mqtt->disconnect();

            Log::info('[MQTT] Publish Success', [

                'topic'   => $fullTopic,

                'payload' => $payload,
            ]);

            return true;

        } catch (\Throwable $e) {

            Log::error('[MQTT] Publish Error', [

                'topic' => $topic,

                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    // =========================================================
    // SUBSCRIBE SINGLE
    // =========================================================

    public function subscribe(
        string $topic,
        callable $callback
    ): void {

        try {

            $mqtt = MQTT::connection();

            $fullTopic = $this->prefix . $topic;

            $mqtt->subscribe(

                topicFilter: $fullTopic,

                callback: function (
                    string $topic,
                    string $message
                ) use ($callback) {

                    Log::info('[MQTT] Message Received', [

                        'topic'   => $topic,

                        'message' => $message,
                    ]);

                    $callback($topic, $message);
                },

                qualityOfService: 1
            );

            Log::info('[MQTT] Subscribe Active', [

                'topic' => $fullTopic,
            ]);

            $mqtt->loop(true);

        } catch (\Throwable $e) {

            Log::error('[MQTT] Subscribe Error', [

                'topic' => $topic,

                'error' => $e->getMessage(),
            ]);
        }
    }

    // =========================================================
    // SUBSCRIBE MULTIPLE
    // =========================================================

    public function subscribeMultiple(
        array $topics
    ): void {

        try {

            $mqtt = MQTT::connection();

            foreach ($topics as $topic => $callback) {

                $fullTopic = $this->prefix . $topic;

                $mqtt->subscribe(

                    topicFilter: $fullTopic,

                    callback: function (
                        string $topic,
                        string $message
                    ) use ($callback) {

                        Log::info('[MQTT] Message Received', [

                            'topic'   => $topic,

                            'message' => $message,
                        ]);

                        $callback($topic, $message);
                    },

                    qualityOfService: 1
                );

                Log::info('[MQTT] Subscribe Added', [

                    'topic' => $fullTopic,
                ]);
            }

            Log::info('[MQTT] Waiting Messages...');

            $mqtt->loop(true);

        } catch (\Throwable $e) {

            Log::error('[MQTT] Subscribe Multiple Error', [

                'error' => $e->getMessage(),
            ]);
        }
    }

    // =========================================================
    // HELPER
    // =========================================================

    public function topic(string $topic): string
    {
        return $this->prefix . $topic;
    }
}