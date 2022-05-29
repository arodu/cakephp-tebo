<?php
declare(strict_types=1);

namespace TeBo\Utility;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Tebo command.
 */
class Bot
{
    public const METHODS = [
        'setWebhook',
        'getWebhookInfo',
        'getMe',
        'deleteWebhook',
        'sendMessage',
    ];

    /**
     * get url webhook to telegram api
     *
     * @return string
     */
    public static function getWebhookUrl(): string
    {
        $config = Configure::read('tebo');
        $url = Router::url($config['webhookUrl'], true);

        return $url;
    }

    public static function buildMethod($name, $data): array
    {
        $telegram = Configure::read('tebo.telegram');
        $url = Text::insert($telegram['api'], [
            'token' => $telegram['token'],
            'method' => $name,
        ]);

        return [
            'url' => $url,
            'data' => $data,
        ];
    }

    public static function __callStatic($name, $arguments)
    {
        if (in_array($name, static::METHODS)) {
            $method = static::buildMethod($name, $arguments[0] ?? null);
            $http = new Client();
            $response = $http->post(
                $method['url'],
                $method['data']
            );

            return $response->getJson();
        }
    }
}
