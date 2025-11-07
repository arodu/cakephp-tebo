<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Log\Log;
use InvalidArgumentException;
use TeBo\Enum\TelegramMethod;
use TeBo\Response\HtmlMessage;
use TeBo\Response\ResponseInterface;
use TeBo\Response\TextMessage;
use TeBo\Utility\Bot;
use TeBo\Utility\Trait\DataManageTrait;
use TeBo\Telegram\Api as TelegramApi;

class Chat
{
    use DataManageTrait;

    const CHAT_ACTION_TYPING = 'typing';
    const CHAT_ACTION_UPLOAD_PHOTO = 'upload_photo';
    const CHAT_ACTION_RECORD_VIDEO = 'record_video';
    const CHAT_ACTION_UPLOAD_VIDEO = 'upload_video';
    const CHAT_ACTION_RECORD_AUDIO = 'record_audio';
    const CHAT_ACTION_UPLOAD_AUDIO = 'upload_audio';
    const CHAT_ACTION_UPLOAD_DOCUMENT = 'upload_document';
    const CHAT_ACTION_FIND_LOCATION = 'find_location';
    const CHAT_ACTION_RECORD_VIDEO_NOTE = 'record_video_note';
    const CHAT_ACTION_UPLOAD_VIDEO_NOTE = 'upload_video_note';

    protected int $id;
    protected ?array $lastResult = null;

    /**
     * @param array $chatData
     */
    public function __construct(array $chatData = [])
    {
        $this->setOriginalData($chatData);
        $this->id = $chatData['id'] ?? null;
        if (empty($this->id)) {
            Log::error('Chat ID is required!', ['config' => $chatData]);
            throw new InvalidArgumentException('Chat ID is required!');
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the last result of the chat.
     *
     * @return array|null The last result of the chat.
     */
    public function getLastResult(): ?array
    {
        return $this->lastResult;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->get('type') ?? '';
    }

    /**
     * @param ResponseInterface $response
     * @return boolean
     */
    public function send(ResponseInterface $response): bool
    {
        $method = $response->telegramMethod();
        if (empty($method)) {
            Log::error('Telegram method is required!', ['response' => $response]);
            throw new InvalidArgumentException('Telegram method is required!');
        }

        $this->lastResult = TelegramApi::call($method, $response->telegramFormat($this->id), $response->httpOptions());
        Bot::debug('Chat response: ', $this->lastResult);

        return $this->lastResult['ok'] ?? false;
    }

    /**
     * @param string|array $html
     * @param array $options
     * @return boolean
     */
    public function sendHtml(string|array $html, array $options = []): bool
    {
        return $this->send(new HtmlMessage($html, $options));
    }

    /**
     * @param string|array $text
     * @param array $options
     * @return boolean
     */
    public function sendText(string|array $text, array $options = []): bool
    {
        return $this->send(new TextMessage($text, $options));
    }

    /**
     * Send chat action.
     *
     * @param string $action The action to send.
     * @return boolean
     */
    public function chatAction(string $action): bool
    {
        $this->lastResult = TelegramApi::call(TelegramMethod::SEND_CHAT_ACTION, [
            'chat_id' => $this->id,
            'action' => $action,
        ]);
        Bot::debug('Chat action response: ', $this->lastResult);

        return $this->lastResult['ok'] ?? false;
    }

    /**
     * Send chat action typing.
     *
     * @return boolean
     */
    public function chatActionTyping(): bool
    {
        return $this->chatAction(self::CHAT_ACTION_TYPING);
    }

    /**
     * @param string $method
     * @param array $data
     * @param array $options
     * @return array
     */
    public function call(TelegramMethod|string $method, array $data = [], array $options = []): array
    {
        $data['chat_id'] = $this->id;
        $this->lastResult = TelegramApi::call($method, $data, $options);
        Bot::debug('Chat call response: ', $this->lastResult);

        return $this->lastResult;
    }

    /**
     * @param string $filePath
     * @return string
     */
    public function downloadFile(string $filePath): string
    {
        return TelegramApi::downloadFile($filePath);
    }
}
