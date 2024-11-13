<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use Cake\Core\InstanceConfigTrait;
use TeBo\Telegram\Enum\TelegramMethod;

class CustomResponse implements ResponseInterface
{
    protected TelegramMethod|string $telegramMethod;
    protected array $httpOptions;
    protected $telegramFormat;

    public function __construct(array $options = [])
    {
        $this->setTelegramFormat($options['telegramFormat'] ?? fn() => []);
        $this->setTelegramMethod($options['telegramMethod'] ?? TelegramMethod::SEND_MESSAGE);
        $this->setHttpOptions($options['httpOptions'] ?? []);
    }

    /**
     * @param callable $callback
     * @return self
     */
    public function setTelegramFormat(callable $callback): self
    {
        $this->telegramFormat = $callback;

        return $this;
    }

    /**
     * @param TelegramMethod|string $method
     * @return self
     */
    public function setTelegramMethod(TelegramMethod|string $method): self
    {
        $this->telegramMethod = $method;

        return $this;
    }

    /**
     * @param array $options
     * @return self
     */
    public function setHttpOptions(array $options): self
    {
        $this->httpOptions = $options;

        return $this;
    }

    /**
     * Get the data for the message.
     *
     * @param int|string|null $chat_id The ID of the chat.
     * @return array The message data.
     */
    public function telegramFormat(int|string $chat_id = null): array
    {
        return call_user_func($this->telegramFormat, $chat_id);
    }

    /**
     * @return string
     */
    public function telegramMethod(): string
    {
        $telegramMethod = $this->telegramMethod;

        if ($telegramMethod instanceof TelegramMethod) {
            return $telegramMethod->getMethod();
        }

        if (is_string($telegramMethod)) {
            return $telegramMethod;
        }

        throw new \InvalidArgumentException('Invalid telegram method');
    }

    /**
     * @return array
     */
    public function httpOptions(): array
    {
        return $this->httpOptions;
    }
}
 