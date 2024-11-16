<?php

declare(strict_types=1);

namespace TeBo\Action;

use TeBo\Action\Action;
use TeBo\Telegram\Update;
use TeBo\Utility\Bot;

class DefaultAction extends Action
{
    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        Bot::debug(__METHOD__, $this->getUpdate()->getOriginalData());
    }
}
