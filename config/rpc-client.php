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
            'router_queue'             => 'default',
            'default_queue'  => 'default',
        ],
        'extensions' => [
            'reply_extension' => true,
            'signal_extension' => true
        ]
    ],
    'rpc' => [

        'process_exception' => \Fthi\LaraRpcRmq\ProcessException::class,


        'command_exception' => \Fthi\LaraRpcRmq\CommandException::class,


        'rpc_queue' => 'membership_rpc_queue',


        'rpc_process_name' => 'membership-service',


        'patterns' => [
            'get-invoice' => [
                'controller' => \App\Http\Controllers\Controller::class,
                'method' => 'test'
            ]
        ]

    ],


];
