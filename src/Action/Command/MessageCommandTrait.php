<?php

declare(strict_types=1);

namespace TeBo\Action\Command;

use TeBo\Telegram\Update;
use TeBo\Utility\MessageCommand;

/**
 * Trait CommandTrait
 *
 * @package TeBo\Action\Command
 * @method Update getUpdate()
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
}
