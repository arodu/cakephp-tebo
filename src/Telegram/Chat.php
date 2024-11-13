<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Log\Log;
use InvalidArgumentException;
use TeBo\Telegram\Response\ResponseInterface;
use TeBo\Utility\Bot;

class Chat
{
    protected int $id;
    protected array $lastResult = null;
    protected array $originalData;

    /**
     * @param array $chatData
     */
    public function __construct(array $chatData = [])
    {
        $this->originalData = $chatData;
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
     * @return array
     */
    public function getOriginalData(): array
    {
        return $this->originalData;
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

        return $this->lastResult['ok'] ?? false;
    }
}
