<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Enum\TelegramMethod;

class CustomResponse implements ResponseInterface
{
    protected TelegramMethod|string $telegramMethod;
    protected array $httpOptions;
    protected mixed $telegramFormat;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->setTelegramFormat($options['telegramFormat'] ?? fn() => []);
        $this->setTelegramMethod($options['telegramMethod'] ?? TelegramMethod::SEND_MESSAGE);
        $this->setHttpOptions($options['httpOptions'] ?? []);
    }

    /**
     * @param array|callable $callback
     * @return self
     */
    public function setTelegramFormat(array|callable $callback): self
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
        if (is_array($this->telegramFormat)) {
            return $this->telegramFormat;
        }

        if (is_callable($this->telegramFormat)) {
            return call_user_func($this->telegramFormat, $chat_id);
        }

        throw new \InvalidArgumentException('Invalid telegram format');
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
 