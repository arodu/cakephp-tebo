<?php
declare(strict_types=1);

namespace TeBo\Utility;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Log\Log;
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
        'sendPhoto',
    ];

    /**
     * get url webhook to telegram api
     *
     * @return string
     */
    public static function getWebhookUrl(): string
    {
        $webhookUrl = Configure::read('tebo.webhookUrl');
        
        return Router::url($webhookUrl, true);
    }

    /**
     * @param string $name
     * @param array $data
     * @param array $options
     * @return array
     */
    public static function buildMethod(string $name, array $data, array $options = []): array
    {
        $telegram = Configure::read('tebo.telegram');
        $url = Text::insert($telegram['api'], [
            'token' => $telegram['token'],
            'method' => $name,
        ]);

        return [
            'url' => $url,
            'data' => $data,
            'options' => $options,
        ];
    }

    public static function __callStatic($name, $arguments)
    {
        if (in_array($name, static::METHODS)) {
            $method = static::buildMethod($name, $arguments[0] ?? null);
            $http = new Client();
            $response = $http->post(
                $method['url'],
                $method['data'],
                $method['options'] ?? []
            );

            return $response->getJson();
        } else {
            throw new \BadMethodCallException('Method not found');
        }
    }

    /**
     * @param string $message
     * @param array $data
     * @return void
     */
    public static function debug(string $message, array $data = []): void
    {
        $debug = Configure::read('tebo.debug');
        if ($debug) {
            Log::debug($message . ': ' . json_encode($data));
        }
    }
}
