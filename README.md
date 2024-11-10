
# TeBo Plugin for CakePHP 5

TeBo is a plugin for integrating a Telegram bot into CakePHP 5 applications, allowing configuration and management of custom commands with easy setup.

## Installation

1. Install the plugin using Composer:
   ```bash
   composer require arodu/tebo
   ```

2. Load the plugin in your project:
   ```bash
   bin/cake plugin load TeBo
   ```

3. Add your Telegram bot token in the `.env` file:
   ```bash
   export TELEGRAM_TOKEN="xxxxx"
   ```

## Webhook Configuration

TeBo offers commands to manage the webhook setup in Telegram. To run these commands, use:

```bash
bin/cake tebo
```

The available options are:

1. **Get Webhook URL**: Displays the current webhook URL configured in the local system.
2. **Set Webhook to Telegram**: Sets the webhook in Telegram, linking the bot to a specific URL to receive updates.
3. **Get Webhook Info from Telegram**: Shows information about the webhook configured in Telegram, including status and connection details.

### Additional Configuration (Optional)

You can add the following values to the `.env` file to enhance webhook functionality:

```bash
export WEBHOOK_OBFUSCATION="string_key"
export WEBHOOK_BASE="url_base"
```

- **WEBHOOK_OBFUSCATION**: Obfuscates the webhook URL, providing an additional security layer.
- **WEBHOOK_BASE**: Sets the base domain for the webhook URL. If not specified, `127.0.0.1` is used, which is incompatible with the Telegram API.

## Bot Testing

Once the webhook and token are configured, the bot should be ready to work. You can test it from Telegram using the following commands:

- `/start`
- `/hello`
- `/about`

## Customization

To customize the bot options, you can create a configuration file in `config/tebo.php` with the following structure:

```php
<?php
return [
    'tebo' => [
        'debug' => true, // Sets whether the bot is in debug mode.
        'webhookUrl' => [ // Specifies the webhook route, useful for custom development.
            'plugin' => 'TeBo', 
            'controller' => 'Bot',
            'action' => 'webhook',
        ],
        'obfuscation' => env('WEBHOOK_OBFUSCATION', null), // Sets the webhook URL obfuscation.
        'command' => [
            'mapper' => [ // Command mapping, where custom commands can be added.
                'default' => \TeBo\TeBo\Command\DefaultCommand::class, // Default command if no other command is found.
                'start' => \TeBo\TeBo\Command\Start::class, 
                'about' => \TeBo\TeBo\Command\About::class,
                'hello' => \TeBo\TeBo\Command\Hello::class,
            ],
            'namespaces' => [
                '\App\TeBo\Command', // Defines additional namespaces for custom commands.
                // Class names must match commands; for example, `/prices` should correspond to `\App\TeBo\Command\Prices` and implement `\TeBo\TeBo\CommandInterface`.
            ],
        ],
    ],
];
```

## Notes

- Ensure that the `.env` file is properly configured before testing the bot.
- The default command executed by the plugin is `\TeBo\TeBo\Command\DefaultCommand::class`. You can disable it by setting it to `null`.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

