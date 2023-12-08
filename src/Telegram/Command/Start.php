<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Chat;
use TeBo\Telegram\Response\ResponseText;
use TeBo\Telegram\Update;

class Start extends BaseCommand
{
    public function help()
    {
    }

    /**
     * @param Chat $chat
     * @param array $originalData
     * @return void
     */
    public function execute(Update $update)
    {
        $update->getChat()->send(new ResponseText('Replace this command!'));
        $update->getChat()->send(new ResponseText('<code>How to replace this command</code>'));
    }
}
