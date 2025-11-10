<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Log\Log;
use InvalidArgumentException;
use TeBo\Enum\TelegramMethod;
use TeBo\Response\Response;
use TeBo\Response\ResponseInterface;
use TeBo\Service\ApiService;
use TeBo\TeBoPlugin;
use TeBo\Utility\Trait\DataManageTrait;

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
    protected ApiService $apiService;

    /**
     * @param array $chatData
     */
    public function __construct(array $chatData, ApiService $apiService)
    {
        $this->setOriginalData($chatData);
        $this->apiService = $apiService;
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

        $this->lastResult = $this->apiService->call(
            $method,
            $response->telegramFormat($this->id),
            $response->httpOptions()
        );

        $event = new Event(TeBoPlugin::EVENT_CHAT_RESPONSE, $this, [
            'response' => $response,
            'result' => $this->lastResult
        ]);
        EventManager::instance()->dispatch($event);

        return $this->lastResult['ok'] ?? false;
    }

    /**
     * @param string|array $html
     * @param array $options
     * @return boolean
     */
    public function sendHtml(string|array $html, array $options = []): bool
    {
        $response = Response::newMessage($html)->asHtml();

        return $this->send($response);
    }

    /**
     * @param string|array $text
     * @param array $options
     * @return boolean
     */
    public function sendText(string|array $text, array $options = []): bool
    {
        $response = Response::newMessage($text)->asHtml(false);

        return $this->send($response);
    }

    /**
     * Send chat action typing.
     *
     * @return boolean
     */
    public function chatActionTyping(): bool
    {
        $response = Response::chatAction(self::CHAT_ACTION_TYPING);

        return $this->send($response);
    }

    /**
     * @param string $filePath
     * @return string
     */
    public function downloadFile(string $fileId): string
    {
        $response = Response::create(TelegramMethod::GET_FILE)->data(['file_id' => $fileId]);
        $result = $this->send($response);
        $filePath = $result['result']['file_path'] ?? null;

        if (!$filePath) {
            throw new \Exception(__('Could not get file_path from Telegram.'));
        }

        return $this->apiService->downloadFile($filePath);
    }

    /**
     * Send chat action.
     *
     * @param string $action The action to send.
     * @return boolean
     * 
     * @deprecated use \TeBo\Response\Response::chatAction() instead
     */
    public function chatAction(string $action): bool
    {
        trigger_deprecation(
            'arodu/tebo',
            '2.1.0',
            'The Chat::chatAction() method is deprecated. Use the TeBo\Response\Response::chatAction() method instead.'
        );

        $response = Response::chatAction($action);

        return $this->send($response);
    }

    public function answerCallbackQuery(string $callbackQueryId, ?string $text = null): bool
    {
        $response = Response::create(TelegramMethod::ANSWER_CALLBACK_QUERY)
            ->text($text)
            ->data(['callback_query_id' => $callbackQueryId]);

        return $this->send($response);
    }

    /**
     * @param string $method
     * @param array $data
     * @param array $options
     * @return array
     * 
     * @deprecated use \TeBo\Response\Response and Chat::send() instead
     */
    public function call(TelegramMethod|string $method, array $data = [], array $options = []): array
    {
        trigger_deprecation(
            'arodu/tebo',
            '2.1.0',
            'The Chat::call() method is deprecated. Use the TeBo\Response\Response class and Chat::send() method instead.'
        );

        $response = Response::create($method)
            ->data($data)
            ->setHttpOptions($options);
        $this->send($response);

        return $this->getLastResult();
    }
}
