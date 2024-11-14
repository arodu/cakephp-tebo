<?php

use TeBo\Enum\UpdateType;

return [
    'tebo' => [
        /**
         * telegram: array with the token and api url
         */
        'telegram' => [
            'token' => env('TELEGRAM_TOKEN', null),
            'api' => env('TELEGRAM_API', \TeBo\Telegram\Api::API_URL),
        ],

        /**
         * webhookUrl: array with the url to receive the webhook
         */
        'webhookUrl' => [
            '_host' => env('WEBHOOK_BASE', '127.0.0.1'),
            '_https' => env('WEBHOOK_SSL', true),
            'plugin' => 'TeBo',
            'controller' => 'Bot',
            'action' => 'webhook',
        ],

        /**
         * obfuscation: null|'sha1' - null for disable obfuscation
         */
        'obfuscation' => env('WEBHOOK_OBFUSCATION', null),
        'actions' => [

            /**
             * actions: array with actions to execute
             * key is UpdateType, value is class name or callable
             * if key is command, the value is an array with the command as key and the class name as value
             * if key is not found, the default action will be executed
             */
            UpdateType::COMMAND->value => [
                'start' => \TeBo\Action\StartAction::class,
                'about' => \TeBo\Action\AboutAction::class,
                //'hello' => \TeBo\Action\HelloAction::class,
                //'example' => \TeBo\Action\ExampleAction::class,
            ],

            //UpdateType::MESSAGE->value => function (\TeBo\Telegram\Update $update) {
            //    return \App\TeBo\Action\MessageAction::class;
            //},

            //UpdateType::CALLBACK_QUERY->value => \App\TeBo\Action\CallbackQueryAction::class,
            //UpdateType::MESSAGE->value => \App\TeBo\Action\MessageAction::class,
            //UpdateType::INLINE_QUERY->value => \App\TeBo\Action\InlineQueryAction::class,
            //UpdateType::CHOSEN_INLINE_RESULT->value => \App\TeBo\Action\ChosenInlineResultAction::class,
            //UpdateType::EDITED_MESSAGE->value => \App\TeBo\Action\EditedMessageAction::class,
            //UpdateType::CHANNEL_POST->value => \App\TeBo\Action\ChannelPostAction::class,
            //UpdateType::EDITED_CHANNEL_POST->value => \App\TeBo\Action\EditedChannelPostAction::class,

            'default' => \TeBo\Action\DefaultAction::class,  // string|callable|array|null
        ],
    ],
];
