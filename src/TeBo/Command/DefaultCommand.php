<?php

declare(strict_types=1);

namespace TeBo\TeBo\Command;

use TeBo\TeBo\CommandInterface;
use TeBo\Telegram\Update;

class DefaultCommand implements CommandInterface
{
    /**
     * @inheritDoc
     */
    public function help(): string
    {
        return __('No help available');
    }

    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        // $update->getChat()->send(new Message('Replace this command!'));
    }
}
