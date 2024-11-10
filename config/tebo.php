<?php

return [
    'tebo' => [
        'debug' => true,
        'telegram' => [
            'token' => env('TELEGRAM_TOKEN', null),
            'api' => env('TELEGRAM_API', 'https://api.telegram.org/bot:token/:method'),
        ],
        'webhookUrl' => [
            '_host' => env('WEBHOOK_BASE', '127.0.0.1'),
            '_https' => env('WEBHOOK_SSL', true),
            'plugin' => 'TeBo',
            'controller' => 'Bot',
            'action' => 'webhook',
        ],
        'obfuscation' => env('WEBHOOK_OBFUSCATION', null),
        'command' => [
            'mapper' => [
                'default' => \TeBo\TeBo\Command\DefaultCommand::class,
                'start' => \TeBo\TeBo\Command\Start::class,
                'about' => \TeBo\TeBo\Command\About::class,
                'hello' => \TeBo\TeBo\Command\Hello::class,
                'example' => \TeBo\TeBo\Command\Example::class,
            ],
            'namespaces' => [
                '\App\TeBo\Command',
            ],
        ],
    ],
];
