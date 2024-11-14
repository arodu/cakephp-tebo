<?php

declare(strict_types=1);

namespace TeBo\Utility;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Utility\Text;
use TeBo\Enum\TelegramMethod;

/**
 * Tebo command.
 */
class Bot
{
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
     * set webhook to telegram api
     *
     * @return array
     */
    public static function __callStatic($name, $arguments)
    {
        $telegramMethod = TelegramMethod::tryFrom($name);
        if (empty($telegramMethod)) {
            throw new \BadMethodCallException('Method not found');
        }

        $http = new Client();
        $telegram = Configure::read('tebo.telegram');
        $url = Text::insert($telegram['api'], [
            'token' => $telegram['token'],
            'method' => $telegramMethod->getMethod(),
        ]);
        $data = $arguments[0] ?? [];
        $httpOptions = $arguments[1] ?? [];
        $response = $http->post($url, $data, $httpOptions);

        return $response->getJson();
    }

    /**
     * @param string $message
     * @param array $data
     * @return void
     */
    public static function debug(string $message, array $data = []): void
    {
        if (Configure::read('debug')) {
            Log::debug($message . ': ' . json_encode($data), 'tebo');
        }
    }
}
