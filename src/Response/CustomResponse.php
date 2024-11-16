<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Enum\TelegramMethod;

class CustomResponse implements ResponseInterface
{
    protected TelegramMethod|string|null $method;
    protected ?array $options;
    protected mixed $format;

    /**
     * @param array $options
     */
    public function __construct(TelegramMethod|string|null $method = null, mixed $format = null, array $options = [])
    {
        $this->method = $method;
        $this->format = $format;
        $this->options = $options;
    }

    /**
     * @param array|callable $callback
     * @return self
     */
    public function setFormat(array|callable $callback): self
    {
        $this->format = $callback;

        return $this;
    }

    /**
     * @param TelegramMethod|string $method
     * @return self
     */
    public function setMethod(TelegramMethod|string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

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
        if (is_array($this->format)) {
            return $this->format;
        }

        if (is_callable($this->format)) {
            return call_user_func($this->format, $chat_id);
        }

        throw new \InvalidArgumentException('Invalid telegram format');
    }

    /**
     * @return string
     */
    public function telegramMethod(): string
    {
        if (is_string($this->method)) {
            return $this->method;
        }

        if ($this->method instanceof TelegramMethod) {
            return $this->method->getMethod();
        }

        throw new \InvalidArgumentException('Invalid telegram method');
    }

    /**
     * @return array
     */
    public function httpOptions(): array
    {
        return $this->options ?? [];
    }
}
 