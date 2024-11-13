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
    const METHOD_SET_WEBHOOK = 'setWebhook';
    const METHOD_GET_WEBHOOK_INFO = 'getWebhookInfo';
    const METHOD_GET_ME = 'getMe';
    const METHOD_DELETE_WEBHOOK = 'deleteWebhook';
    const METHOD_SEND_MESSAGE = 'sendMessage';
    const METHOD_SEND_PHOTO = 'sendPhoto';
    const METHOD_SET_MY_COMMANDS = 'setMyCommands';
    const METHOD_GET_MY_COMMANDS = 'getMyCommands';
    const METHOD_DELETE_MY_COMMANDS = 'deleteMyCommands';

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
    public static function buildMethod(string $name, array $data = [], array $options = []): array
    {
        $telegram = Configure::read('tebo.telegram');
        $url = Text::insert($telegram['api'], [
            'token' => $telegram['token'],
            'method' => $name,
        ]);

        return [
            'url' => $url,
            'data' => $data,
            'httpOptions' => $options,
        ];
    }

    public static function __callStatic($name, $arguments)
    {
        if (isset(self::$name)) {
            $method = static::buildMethod($name, $arguments[0] ?? [], $arguments[1] ?? []);
            $http = new Client();

            $response = $http->post(
                $method['url'],
                $method['data'],
                $method['httpOptions'] ?? []
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
        if (Configure::read('debug')) {
            Log::debug($message . ': ' . json_encode($data), 'tebo');
        }
    }
}
