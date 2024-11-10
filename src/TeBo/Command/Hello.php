<?php
declare(strict_types=1);

namespace TeBo\TeBo\Command;

use TeBo\TeBo\AbstractCommand;
use TeBo\TeBo\CommandInterface;
use TeBo\Telegram\Response\TextMessage;
use TeBo\Telegram\Update;

class Hello extends AbstractCommand implements CommandInterface
{
    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        $update->getChat()->send(new TextMessage('Hello World from TeBo!'));
    }
}
