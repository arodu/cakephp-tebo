<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Response\Text;
use TeBo\Telegram\Update;

class Hello extends BaseCommand
{
    public function help()
    {
    }

    public function execute(Update $update)
    {
        $update->getChat()->send(new Text('Hello World from TeBo!'));
    }
}
