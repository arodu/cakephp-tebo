<?php
declare(strict_types=1);

namespace TeBo\TeBo\Command;

use TeBo\TeBo\AbstractCommand;
use TeBo\TeBo\CommandInterface;
use TeBo\Telegram\Update;

class DefaultCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        // $update->getChat()->send(new Message('Replace this command!'));
    }
}
