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
     * @param MessageCommand $messageCommand
     * @return static
     */
    public function setMessageCommand(MessageCommand $messageCommand): static
    {
        $this->messageCommand = $messageCommand;

        return $this;
    }

    /**
     *
     * @param array $args
     * @return static
     */
    public function setArguments(array $args): static
    {
        $this->getMessageCommand()->setArguments($args);

        return $this;
    }
}
