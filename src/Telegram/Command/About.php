<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Response\ResponseText;
use TeBo\Telegram\Update;

class About extends BaseCommand
{
    public function help()
    {
    }

    public function execute(Update $update)
    {
        $update->getChat()->send(new ResponseText('About TeBo:'));
    }
}
