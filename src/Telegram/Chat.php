<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Log\Log;
use InvalidArgumentException;
use TeBo\Telegram\Response\ResponseInterface;
use TeBo\Utility\Bot;
use TeBo\Utility\Trait\DataManageTrait;

class Chat
{
    use DataManageTrait;

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

        $this->lastResult = Bot::$method($response->telegramFormat($this->id), $response->httpOptions());

        Bot::debug('Chat response: ', $this->lastResult);

        return $this->lastResult['ok'] ?? false;
    }
}
