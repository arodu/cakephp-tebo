<?php

declare(strict_types=1);

use TeBo\Enum\UpdateType;

return [
    'tebo' => [
        /**
         * Telegram configuration:
         * Contains the authentication token and the base URL for the Telegram API.
         */
        'telegram' => [
            'token' => env('TELEGRAM_TOKEN', null),
            'api' => env('TELEGRAM_API', \TeBo\Telegram\Api::API_URL),
        ],

        /**
         * Webhook URL configuration:
         * Defines the URL to receive Telegram webhooks.
         * - _host: Base host for the webhook URL (default is 127.0.0.1).
         * - _https: Indicates if HTTPS is used (default is true).
         * - plugin, controller, action: Controller components that will handle the webhook requests.
         */
        'webhookUrl' => [
            '_host' => env('WEBHOOK_BASE', '127.0.0.1'),
            '_https' => env('WEBHOOK_SSL', true),
            'plugin' => 'TeBo',
            'controller' => 'Bot',
            'action' => 'webhook',
        ],

        /**
         * Webhook obfuscation configuration:
         * Determines if URL obfuscation is applied for the webhook.
         * - null to disable obfuscation.
         * - A string to use as a secret key for obfuscation.
         */
        'obfuscation' => env('WEBHOOK_OBFUSCATION', null),
        'actions' => [

            /**
             * Configured actions:
             * Defines the actions to execute based on the update type.
             * - Key is the update type (UpdateType).
             * - Value can be a class name, callable function, or an array of commands.
             * - For commands, the key is the command name, and the value is the corresponding class name.
             * - If no specific key is found, the default action will be executed.
             */
            UpdateType::COMMAND->value => [
                'start' => \TeBo\Action\StartAction::class,  // Action for the 'start' command.
                'about' => \TeBo\Action\AboutAction::class,  // Action for the 'about' command.
                'help' => \TeBo\Action\HelpAction::class,    // Action for the 'help' command.
                //'hello' => \TeBo\Action\HelloAction::class,
                //'example' => \TeBo\Action\ExampleAction::class,
            ],

            /**
             * Example configuration for other actions based on update type
             */
            //UpdateType::MESSAGE->value => function (\TeBo\Telegram\Update $update) {
            //    return \App\TeBo\Action\MessageAction::class;
            //},
            //UpdateType::CALLBACK_QUERY->value => \App\TeBo\Action\CallbackQueryAction::class,
            //UpdateType::INLINE_QUERY->value => \App\TeBo\Action\InlineQueryAction::class,
            //UpdateType::CHOSEN_INLINE_RESULT->value => \App\TeBo\Action\ChosenInlineResultAction::class,
            //UpdateType::EDITED_MESSAGE->value => \App\TeBo\Action\EditedMessageAction::class,
            //UpdateType::CHANNEL_POST->value => \App\TeBo\Action\ChannelPostAction::class,
            //UpdateType::EDITED_CHANNEL_POST->value => \App\TeBo\Action\EditedChannelPostAction::class,

            'default' => \TeBo\Action\DefaultAction::class,  // Default action if no match is found.
        ],

        /**
         * Command descriptions:
         * Defines descriptions for each command supported by the bot.
         * - Key is the command name, and value is the description.
         * - If null, descriptions can be generated using a CLI command like 'tebo commands'.
         * 
         *      'commandDescriptions' => [
         *          'start' => 'Start the bot',
         *          'about' => 'Information about the bot',
         *      ],
         */
        'commandDescriptions' => null,
    ],
];
