<?php

declare(strict_types=1);

namespace TeBo\Action\Command;

/**
 * Trait MessageCommand
 */
trait MessageCommandTrait
{
    /**
     * @var MessageCommand
     */
    protected MessageCommand $messageCommand;

    /**
     * @return MessageCommand
     */
    public function getMessageCommand(): MessageCommand
    {
        if (empty($this->messageCommand)) {
            $this->messageCommand = new MessageCommand($this->getUpdate()->getMessage());
        }

        return $this->messageCommand;
    }

    /**
     *
     * @param array $args
     * @return static
     */
    public function setArguments(array $args): static
    {
        $this->getMessageCommand()->setConfig('arguments', $args);

        return $this;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->getMessageCommand()->getArguments();
    }
}
