
# TeBo: CakePHP plugin for Telegram Bot

> [!WARNING]  
> This plugin is under development and not ready for production. 

TeBo is a plugin that integrates a Telegram bot into CakePHP 5 applications, allowing configuration and management of custom commands with an easy setup.

## Installation

1. Install the plugin using Composer:
   ```bash
   composer require arodu/tebo
   ```

2. Load the plugin in your project:
   ```bash
   bin/cake plugin load TeBo
   ```

3. Add your Telegram bot token to the `.env` file:
   ```bash
   export TELEGRAM_TOKEN="xxxxx"
   ```

## Webhook Configuration

TeBo offers commands to manage the webhook setup in Telegram. To run these commands, use:

```bash
bin/cake tebo
```

The available options are:

1. **Get Webhook URL**: Displays the current webhook URL configured on the local system.
2. **Set Webhook to Telegram**: Sets the webhook on Telegram, linking the bot to a specific URL to receive updates.
3. **Get Webhook Info from Telegram**: Shows information about the webhook configured on Telegram, including status and connection details.

### Additional Configuration (Optional)

You can add the following values to the `.env` file to enhance webhook functionality:

```bash
export WEBHOOK_OBFUSCATION="your_obfuscation_key_here"
export WEBHOOK_BASE="your_base_url_here"
```

- **WEBHOOK_OBFUSCATION**: Obfuscates the webhook URL, adding an additional security layer.
- **WEBHOOK_BASE**: Sets the base domain for the webhook URL. If not specified, `127.0.0.1` is used, which is incompatible with the Telegram API.

## Bot Testing

Once the webhook and token are configured, the bot should be ready to work. You can test it on Telegram using the following commands:

- `/start`
- `/hello`
- `/about`

## Customization

To customize the bot's options, you can create a configuration file in `config/tebo.php` with the following structure:

```php
<?php
return [
    'tebo' => [
        'webhookUrl' => [ // Specifies the webhook route, useful for custom development.
            'plugin' => 'TeBo', 
            'controller' => 'Bot',
            'action' => 'webhook',
        ],
        'obfuscation' => env('WEBHOOK_OBFUSCATION', null), // Sets the webhook URL obfuscation.
        'command' => [
            'mapper' => [ // Command mapping, allowing for custom commands.
                'default' => \TeBo\TeBo\Command\DefaultCommand::class, // Default command if no other command is found.
                'start' => \TeBo\TeBo\Command\Start::class, 
                'about' => \TeBo\TeBo\Command\About::class,
                'hello' => \TeBo\TeBo\Command\Hello::class,
            ],
            'namespaces' => [
                '\App\TeBo\Command', // Defines additional namespaces for custom commands.
                // Command classes must match commands; for example, `/prices` should correspond to `\App\TeBo\Command\Prices` and implement `\TeBo\TeBo\CommandInterface`.
            ],
        ],
    ],
];
```

## Usage

The plugin provides a default command that can be extended to create custom commands. To create a new command, follow these steps:

1. Create a new command class in the `src/Command` directory.
2. Extend from `TeBoCommand` or Implement the `CommandInterface` interface.
3. Add the command to the `config/tebo.php` file.

```php
<?php
namespace App\TeBo\Command;

class Prices extends \TeBo\TeBo\TeBoCommand
{
    public function help(): ?string
    {
        return null;
    }

    public function execute(\TeBo\Telegram\Update $update): void
    {
        $update->getChat()->send(new \TeBo\Telegram\Response\TextMessage('The current prices are: $100'));
    }
}
```

To add the command to the configuration file:

```php
'command' => [
    'mapper' => [
        'prices' => \App\TeBo\Command\Prices::class,
    ],
],
```

After adding the command, you can test it by sending `/prices` to the bot.

### Send an HTML Formatted Message
To send a message with HTML formatting, use HtmlMessage:

```php
$update->reply(new \TeBo\Telegram\Response\HtmlMessage([
    '<b>HTML Message</b>',
    '',
    'This is an example of an HTML message.',
    'You can use basic HTML tags to format the text.',
    'Example: <b>bold</b>, <i>italic</i>, <a href="https://example.com">link</a>',
    'Refer to Telegram API documentation for more info.',
]));
```

In this example, HTML tags such as `<b>`, `<i>`, `<a>`, and `<code>` are supported for text formatting.

### Send a Photo
- **Example 1**: Send a Local Photo  
If the image is stored locally, use the path to the image file:

```php
$file = fopen(TEBO_CORE_PATH . DS . '/resources/tebo.jpg', 'rb');
$photo = new \TeBo\Telegram\Response\Photo($file, 'This is a placeholder image.');
$update->reply($photo);
```

- **Example 2**: Send a Photo from a URL with a Caption  
You can also send a photo from a URL with a custom caption:

```php
$photo = new \TeBo\Telegram\Response\Photo('https://placehold.it/300x200');
$update->reply($photo);
```

### Sending with a chat ID

To send a message to a specific chat ID, use the following code:

```php
$chatId = '12345678'; // The Telegram chat ID to send the message to
$chat = new \TeBo\Telegram\Chat(['id' => $chatId]); // Creates a Chat instance with the specified ID
$message = new \TeBo\Telegram\Response\TextMessage('Hello!'); // Creates the text message to send
$chat->send($message); // Sends the message to the specified chat
```

## Notes

- Ensure that the `.env` file is properly configured before testing the bot.
- The default command executed by the plugin is `\TeBo\TeBo\Command\DefaultCommand::class`. You can disable it by setting it to `null`.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
