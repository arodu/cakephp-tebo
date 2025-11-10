<?php

declare(strict_types=1);

namespace TeBo\Service;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Utility\Text;
use TeBo\Enum\TelegramMethod;

/**
 * Class Api
 *
 * @package TeBo\Telegram
 * 
 * @method array getMe(array $data = [], array $options = [])
 * @method array sendMessage(array $data = [], array $options = [])
 * @method array forwardMessage(array $data = [], array $options = [])
 * @method array sendPhoto(array $data = [], array $options = [])
 * @method array sendAudio(array $data = [], array $options = [])
 * @method array sendDocument(array $data = [], array $options = [])
 * @method array sendVideo(array $data = [], array $options = [])
 * @method array sendAnimation(array $data = [], array $options = [])
 * @method array sendVoice(array $data = [], array $options = [])
 * @method array sendVideoNote(array $data = [], array $options = [])
 * @method array sendMediaGroup(array $data = [], array $options = [])
 * @method array sendLocation(array $data = [], array $options = [])
 * @method array editMessageLiveLocation(array $data = [], array $options = [])
 * @method array stopMessageLiveLocation(array $data = [], array $options = [])
 * @method array sendVenue(array $data = [], array $options = [])
 * @method array sendContact(array $data = [], array $options = [])
 * @method array sendPoll(array $data = [], array $options = [])
 * @method array sendDice(array $data = [], array $options = [])
 * @method array sendChatAction(array $data = [], array $options = [])
 * @method array getUserProfilePhotos(array $data = [], array $options = [])
 * @method array getFile(array $data = [], array $options = [])
 * @method array kickChatMember(array $data = [], array $options = [])
 * @method array unbanChatMember(array $data = [], array $options = [])
 * @method array restrictChatMember(array $data = [], array $options = [])
 * @method array setWebhook(array $data = [], array $options = [])
 */
class ApiService
{
    public const API_URL = 'https://api.telegram.org/bot:token/:method';
    public const FILE_API_URL = 'https://api.telegram.org/file/bot:token/:file_path';

    /**
     * @param TelegramMethod|string $method
     * @param array $data
     * @param array $options
     * @return array
     */
    public function call(TelegramMethod|string $method, array $data = [], array $options = []): array
    {
        $method = $this->getTelegramMethod($method);
        $http = new Client();
        $telegram = Configure::read('tebo.telegram');

        if (empty($telegram['token'])) {
            throw new \RuntimeException('Telegram configuration not found');
        }

        $url = Text::insert($telegram['api'] ?? self::API_URL, [
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
    public function __call(string $name, array $arguments): array
    {
        return $this->call($name, $arguments[0] ?? [], $arguments[1] ?? []);
    }

    /**
     * @param string $filePath
     * @return string
     */
    public function downloadFile(string $filePath): string
    {
        $telegram = Configure::read('tebo.telegram');

        if (empty($telegram['token'])) {
            throw new \RuntimeException('Telegram configuration not found');
        }

        $url = Text::insert($telegram['fileApi'] ?? self::FILE_API_URL, [
            'token' => $telegram['token'],
            'file_path' => $filePath,
        ]);

        $http = new Client();
        $response = $http->get($url);

        if (!$response->isOk()) {
            throw new \Exception(__('Could not download file from Telegram.'));
        }

        return $response->getBody()->getContents();
    }

    /**
     * @param TelegramMethod|string $method
     * @return TelegramMethod
     */
    protected function getTelegramMethod(TelegramMethod|string $method): TelegramMethod
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
