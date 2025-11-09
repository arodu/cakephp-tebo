<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Utility\Text;
use TeBo\Enum\TelegramMethod;

/**
 * Class Api
 *
 * @package TeBo\Telegram
 * 
 * @method static array getMe(array $data = [], array $options = [])
 * @method static array sendMessage(array $data = [], array $options = [])
 * @method static array forwardMessage(array $data = [], array $options = [])
 * @method static array sendPhoto(array $data = [], array $options = [])
 * @method static array sendAudio(array $data = [], array $options = [])
 * @method static array sendDocument(array $data = [], array $options = [])
 * @method static array sendVideo(array $data = [], array $options = [])
 * @method static array sendAnimation(array $data = [], array $options = [])
 * @method static array sendVoice(array $data = [], array $options = [])
 * @method static array sendVideoNote(array $data = [], array $options = [])
 * @method static array sendMediaGroup(array $data = [], array $options = [])
 * @method static array sendLocation(array $data = [], array $options = [])
 * @method static array editMessageLiveLocation(array $data = [], array $options = [])
 * @method static array stopMessageLiveLocation(array $data = [], array $options = [])
 * @method static array sendVenue(array $data = [], array $options = [])
 * @method static array sendContact(array $data = [], array $options = [])
 * @method static array sendPoll(array $data = [], array $options = [])
 * @method static array sendDice(array $data = [], array $options = [])
 * @method static array sendChatAction(array $data = [], array $options = [])
 * @method static array getUserProfilePhotos(array $data = [], array $options = [])
 * @method static array getFile(array $data = [], array $options = [])
 * @method static array kickChatMember(array $data = [], array $options = [])
 * @method static array unbanChatMember(array $data = [], array $options = [])
 * @method static array restrictChatMember(array $data = [], array $options = [])
 */
class Api
{
    const API_URL = 'https://api.telegram.org/bot:token/:method';
    const FILE_API_URL = 'https://api.telegram.org/file/bot:token/:file_path';

    /**
     * Call telegram api
     *
     * @param TelegramMethod|string $method
     * @param array $data
     * @param array $options
     * @return array
     */
    public static function call(TelegramMethod|string $method, array $data = [], array $options = []): array
    {
        $method = static::getTelegramMethod($method);
        $http = new Client();
        $telegram = Configure::read('tebo.telegram');

        if (empty($telegram['token'])) {
            throw new \RuntimeException('Telegram configuration not found');
        }

        $url = Text::insert($telegram['api'] ?? static::API_URL, [
            'token' => $telegram['token'],
            'method' => $method->getMethod(),
        ]);

        if (isset($data['reply_markup']) && is_array($data['reply_markup'])) {
            $data['reply_markup'] = json_encode($data['reply_markup']);
        }

        $response = $http->post($url, $data, $options);

        return $response->getJson();
    }

    /**
     * @return array
     */
    public static function __callStatic(string $name, array $arguments): array
    {
        return static::call($name, $arguments[0] ?? [], $arguments[1] ?? []);
    }

    /**
     * @param string $filePath
     * @return string
     */
    public static function downloadFile(string $filePath): string
    {
        $telegram = Configure::read('tebo.telegram');

        if (empty($telegram['token'])) {
            throw new \RuntimeException('Telegram configuration not found');
        }

        $url = Text::insert($telegram['fileApi'] ?? static::FILE_API_URL, [
            'token' => $telegram['token'],
            'file_path' => $filePath,
        ]);

        $http = new Client();
        $response = $http->get($url);

        if (!$response->isOk()) {
            throw new \Exception('Falló la descarga del archivo de Telegram.');
        }

        return $response->getBody()->getContents();
    }

    /**
     * @param TelegramMethod|string $method
     * @return TelegramMethod
     */
    protected static function getTelegramMethod(TelegramMethod|string $method): TelegramMethod
    {
        if (is_string($method)) {
            $method = TelegramMethod::tryFrom($method);
        }

        if ($method instanceof TelegramMethod) {
            return $method;
        }

        throw new \InvalidArgumentException('Invalid method ' . $method);
    }
}
