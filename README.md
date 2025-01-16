
# TeBo: CakePHP plugin for Telegram Bot

[![Latest Version](https://img.shields.io/github/v/release/arodu/cakephp-tebo.svg?style=for-the-badge)](https://github.com/arodu/cakephp-tebo/releases)
[![Packagist License](https://img.shields.io/packagist/l/arodu/tebo?style=for-the-badge)](LICENSE)
[![GitHub Repo stars](https://img.shields.io/github/stars/arodu/cakephp-tebo?style=for-the-badge)](https://github.com/arodu/cakephp-tebo/stargazers)
[![Total Downloads](https://img.shields.io/packagist/dt/arodu/tebo.svg?style=for-the-badge)](https://packagist.org/packages/arodu/tebo)

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

3. Add your Telegram bot token to the `.env` file, or set it as an environment variable:
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
2. **Set Webhook to telegram**: Sets the webhook on Telegram, linking the bot to a specific URL to receive updates.
3. **Delete Webhook from telegram**: Deletes the webhook from Telegram, stopping the bot from receiving updates.
4. **Get Webhook info from telegram**: Shows information about the webhook configured on Telegram, including status and connection details.
5. **Get bot info**: Displays information about the bot, including the bot's name, username, and ID.

### Additional Configuration (Optional)

You can add the following values to the `.env` file to enhance webhook functionality:

```bash
export WEBHOOK_OBFUSCATION="your_obfuscation_key_here"
export WEBHOOK_BASE="your_base_url_here"
```

- **WEBHOOK_OBFUSCATION**: Obfuscates the webhook URL, adding an additional security layer.
- **WEBHOOK_BASE**: Sets the base domain for the webhook URL. If not specified, `127.0.0.1` is used, which is incompatible with the Telegram API.

Here's the translated version of the section:

---

### Configuring CSRF Protection

CakePHP includes built-in protection against Cross-Site Request Forgery (CSRF) attacks. However, to allow Telegram webhooks to work properly with TeBo, you need to exclude requests coming from the plugin from this protection.

To do this, adjust the middleware configuration in the `src/Application.php` file. Modify the `middleware` method to include the following logic:

```php
public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
{
    $csrf = new CsrfProtectionMiddleware(['httponly' => true]);

    $csrf->skipCheckCallback(function ($request) {
        // Exclude requests from the TeBo plugin from CSRF protection
        if ($request->getParam('plugin') === 'TeBo') {
            return true;
        }
    });

    $middlewareQueue->add($csrf);

    return $middlewareQueue;
}
```

> [!WARNING]
> ***Why Is This Necessary?***
> Telegram cannot send custom headers (such as CSRF tokens), which would cause webhook requests to be rejected if CSRF protection is enabled. By configuring this exclusion, we allow Telegram to interact with our application without compromising the overall security.

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
        'actions' => [
            'command' => [ // Command mapping, allowing for custom actions.
                'start' => \TeBo\Action\Command\StartAction::class, // Action for the '/start' command.
                'about' => \TeBo\Action\Command\AboutAction::class, // Action for the '/about' command.
                'help' => \TeBo\Action\Command\HelpAction::class, // Action for the '/help' command.
                'default' => \TeBo\Action\Command\NotFoundAction::class, // Action for the default command, executed when no command is found.
            ],
            'default' => \TeBo\Action\DefaultAction::class,  // Default action if no match is found.
        ],
    ],
];
```
> [!NOTE]
> You can find more information about this file on `config/tebo.php` in the plugin's directory.

## Usage

The plugin provides a default Action that can be extended to create custom actions. To create a new action, follow these steps:

1. Create a new command class in the `src/Actions` directory.
2. Extend from `\TeBo\Action\Action` or Implement the `\TeBo\Action\ActionInterface` interface.
3. Add the command to the `config/tebo.php` file.

```php
<?php
namespace App\Actions;

class Prices extends \TeBo\Action\Action
{
    public static function description(): ?string
    {
        return 'Get the current prices.';
    }

    public function execute(): void
    {
        $message = new \TeBo\Response\TextMessage('The current price is $100');
        $this->getChat()->send($message);
    }
}
```

To add the command to the configuration file `config/tebo.php`, use the following code:

```php
'actions' => [
    'command' => [
        'prices' => \App\Actions\Prices::class,
    ],
],
```

> [!NOTE]
> After adding the command, you can test it by sending `/prices` to the bot.

### Bake a New Action
Also, you can bake a new action using the following command:

```bash
bin/cake bake action Prices
```

### Send an HTML Formatted Message
To send a message with HTML formatting, use HtmlMessage:

```php
$message = new \TeBo\Response\HtmlMessage([
    '<b>HTML Message</b>',
    '',
    'This is an example of an HTML message.',
    'You can use basic HTML tags to format the text.',
    'Example: <b>bold</b>, <i>italic</i>, <a href="https://example.com">link</a>',
    'Refer to Telegram API documentation for more info.',
]);

$this->getChat()->send($message);
```

> [!NOTE]
> In this example, HTML tags such as `<b>`, `<i>`, `<a>`, and `<code>` are supported for text formatting.

### Send a Photo
- **Example 1**: Send a Local Photo  
If the image is stored locally, use the path to the image file:

```php
$file = fopen(TEBO_CORE_PATH . DS . '/resources/tebo.jpg', 'rb');
$photo = new \TeBo\Response\Photo($file, 'This is a placeholder image.');
$update->reply($photo);
```

- **Example 2**: Send a Photo from a URL with a Caption  
You can also send a photo from a URL with a custom caption:

```php
$photo = new \TeBo\Response\Photo('https://placehold.it/300x200');
$update->reply($photo);
```

### Sending with a chat ID

To send a message to a specific chat ID, use the following code:

```php
$chatId = '12345678'; // The Telegram chat ID to send the message to
$chat = new \TeBo\Telegram\Chat(['id' => $chatId]); // Creates a Chat instance with the specified ID
$message = new \TeBo\Response\TextMessage('Hello!'); // Creates the text message to send
$chat->send($message); // Sends the message to the specified chat
```

## Notes

- Ensure that the `.env` file is properly configured before testing the bot.
- The default command executed by the plugin is `\TeBo\Action\Command\NotFoundAction::class`. You can disable it by setting it to `null`.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
