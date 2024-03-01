<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Response\Message;
use TeBo\Telegram\Update;

class Hello extends BaseCommand
{
    public function execute(Update $update)
    {
        $update->getChat()->send(new Message('Hello World from TeBo!'));
    }
}
