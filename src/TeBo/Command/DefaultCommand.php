<?php

declare(strict_types=1);

namespace TeBo\TeBo\Command;

use TeBo\TeBo\TeBoCommand;
use TeBo\Telegram\Update;

class DefaultCommand extends TeBoCommand
{
    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        // $update->getChat()->send(new Message('Replace this command!'));
    }
}
