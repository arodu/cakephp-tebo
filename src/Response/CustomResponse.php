<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Enum\TelegramMethod;
use TeBo\Telegram\LegacyResponseBuilder;

/**
 * @deprecated use \TeBo\Response\Response::create() instead
 */
class CustomResponse implements ResponseInterface
{
    protected ?LegacyResponseBuilder $builder;
    protected mixed $format;
    protected array $options;
    protected TelegramMethod|string|null $method;

    public function __construct(TelegramMethod|string|null $method = null, mixed $format = null, array $options = [])
    {
        $this->method = $method;
        $this->format = $format;
        $this->options = $options;
        $this->builder = null;

        if (is_array($this->format) && $this->method) {
            $this->builder = LegacyResponseBuilder::create($this->method);
            $this->builder->addOptions($this->format);
        }
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

    public function telegramFormat(int|string|null $chat_id = null): array
    {
        if (is_callable($this->format)) {
            return call_user_func($this->format, $chat_id);
        }

        if ($this->builder) {
            return $this->builder->telegramFormat($chat_id);
        }

        if (is_array($this->format)) {
            return $this->format;
        }

        throw new \InvalidArgumentException('Invalid telegram format');
    }

    public function telegramMethod(): string
    {
        if ($this->builder) {
            return $this->builder->telegramMethod();
        }

        if (is_string($this->method)) {
            return $this->method;
        }
        if ($this->method instanceof TelegramMethod) {
            return $this->method->getMethod();
        }

        throw new \InvalidArgumentException('Invalid telegram method');
    }

    public function httpOptions(): array
    {
        if ($this->builder) {
            return $this->builder->httpOptions();
        }

        return $this->options ?? [];
    }
}
