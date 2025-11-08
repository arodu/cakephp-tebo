<?php

declare(strict_types=1);

namespace TeBo\Response;

use Cake\Core\InstanceConfigTrait;
use TeBo\Enum\TelegramMethod;

/**
 * @deprecated use \TeBo\Telegram\Response::create() instead
 */
abstract class AbstractResponse implements ResponseInterface
{
    use InstanceConfigTrait;

    protected TelegramMethod|string $method;

    protected array $_defaultConfig = [
        'httpOptions' => [],
    ];

    /**
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * @return string|null
     */
    public function telegramMethod(): string
    {
        if ($this->method instanceof TelegramMethod) {
            return $this->method->getMethod();
        }

        if (is_string($this->method)) {
            return $this->method;
        }

        throw new \InvalidArgumentException('Telegram method is required!');
    }

    /**
     * @return array
     */
    public function httpOptions(): array
    {
        return $this->getConfig('httpOptions') ?? [];
    }
}
