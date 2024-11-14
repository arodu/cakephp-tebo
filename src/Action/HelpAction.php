<?php

declare(strict_types=1);

namespace TeBo\Action;

use TeBo\Action\Action;
use TeBo\Telegram\Update;
use TeBo\Utility\Bot;

class HelpAction extends Action
{
    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        Bot::debug(__METHOD__, $update->getOriginalData());
    }
}
