<?php

return [
    'client' => [
        'transport' => [
            'dsn' => 'amqp://test:test@rabbitmq:5672/%2f'
        ],
        'client' => [
            'prefix' => 'rpc',
            'app_name' => 'odin',
            'router_topic'             => 'default',
            'router_queue'             => 'membership',
            'default_queue'  => 'membership',
        ],
        'extensions' => [
            'reply_extension' => true,
            'signal_extension' => true
        ]
    ],
    'patterns' => [
        'test-command' => [
            'controller' => \App\Http\Controllers\Controller::class,
            'method' => 'test'
        ]
    ]
];
