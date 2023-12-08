<?php

declare(strict_types=1);

namespace Tebo\Telegram\Response;

trait ResponseTrait
{
    /**
     * @var array $options The options property of the message.
     */
    protected array $options = [];

    public function addOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function resetOptions(): self
    {
        $this->options = [];

        return $this;
    }
}
