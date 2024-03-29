<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use Cake\Core\InstanceConfigTrait;

trait ResponseTrait
{
    use InstanceConfigTrait;

    /**
     * @var array $options The options property of the message.
     */
    protected array $options = [];

    /**
     * @param array $options
     * @return self
     */
    public function addOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return self
     */
    public function resetOptions(): self
    {
        $this->options = [];

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTelegramMethod(): ?string
    {
        return $this->getConfig('telegramMethod', null);
    }
}
