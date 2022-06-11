<?php

return [
    'tebo' => [
        'telegram' => [
            'token' => env('TELEGRAM_TOKEN', null),
            'api' => env('TELEGRAM_API', 'https://api.telegram.org/bot:token/:method'),
        ],
        'webhookUrl' => [
            '_host' => env('WEBHOOK_BASE', '127.0.0.1'),
            '_ssl' => env('WEBHOOK_SSL', true),
            'plugin' => 'TeBo',
            'controller' => 'Api',
            'action' => 'webhook',
        ],
        'obfuscation' => env('OBFUSCATION', null),
        'command' => [
            'map' => [
                'start' => \TeBo\Telegram\Command\Start::class,
            ],
            'namespaces' => [
                0 => '\App\Telegram\Command',
                1 => '\TeBo\Telegram\Command',
            ],
        ]
    ],
];
