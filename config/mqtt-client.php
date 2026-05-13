<?php

declare(strict_types=1);

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Repositories\MemoryRepository;

return [

    'default_connection' => 'default',

    'connections' => [

        'default' => [

            'host'      => env('MQTT_HOST'),
            'port'      => env('MQTT_PORT', 8883),
            'protocol'  => MqttClient::MQTT_3_1,
            'client_id' => env('MQTT_CLIENT_ID', 'easypark-v3-laravel'),

            'use_clean_session' => env('MQTT_CLEAN_SESSION', true),
            'enable_logging'    => env('MQTT_ENABLE_LOGGING', true),
            'log_channel'       => env('MQTT_LOG_CHANNEL', null),

            'repository' => MemoryRepository::class,

            'connection_settings' => [

                'tls' => [
                    'enabled'                        => env('MQTT_TLS_ENABLED', true),
                    'allow_self_signed_certificate'  => env('MQTT_TLS_ALLOW_SELF_SIGNED_CERT', false),
                    'verify_peer'                    => env('MQTT_TLS_VERIFY_PEER', true),
                    'verify_peer_name'               => env('MQTT_TLS_VERIFY_PEER_NAME', true),
                    'ca_file'                        => env('MQTT_TLS_CA_FILE'),
                    'ca_path'                        => env('MQTT_TLS_CA_PATH'),
                    'client_certificate_file'        => env('MQTT_TLS_CLIENT_CERT_FILE'),
                    'client_certificate_key_file'    => env('MQTT_TLS_CLIENT_CERT_KEY_FILE'),
                    'client_certificate_key_passphrase' => env('MQTT_TLS_CLIENT_CERT_KEY_PASSPHRASE'),
                    'alpn'                           => env('MQTT_TLS_ALPN'),
                ],

                'auth' => [
                    'username' => env('MQTT_AUTH_USERNAME'),
                    'password' => env('MQTT_AUTH_PASSWORD'),
                ],

                'last_will' => [
                    'topic'               => env('MQTT_LAST_WILL_TOPIC', 'easypark/parking/status/server'),
                    'message'             => env('MQTT_LAST_WILL_MESSAGE', 'offline'),
                    'quality_of_service'  => env('MQTT_LAST_WILL_QUALITY_OF_SERVICE', 1),
                    'retain'              => env('MQTT_LAST_WILL_RETAIN', true),
                ],

                'connect_timeout'      => env('MQTT_CONNECT_TIMEOUT', 60),
                'socket_timeout'       => env('MQTT_SOCKET_TIMEOUT', 5),
                'resend_timeout'       => env('MQTT_RESEND_TIMEOUT', 10),
                'keep_alive_interval'  => env('MQTT_KEEP_ALIVE_INTERVAL', 10),

                'auto_reconnect' => [
                    'enabled'                              => env('MQTT_AUTO_RECONNECT_ENABLED', true),
                    'max_reconnect_attempts'               => env('MQTT_AUTO_RECONNECT_MAX_RECONNECT_ATTEMPTS', 5),
                    'delay_between_reconnect_attempts'     => env('MQTT_AUTO_RECONNECT_DELAY_BETWEEN_RECONNECT_ATTEMPTS', 3),
                ],

            ],

        ],

    ],

];