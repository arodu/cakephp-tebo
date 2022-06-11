<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Message\TextMessage;
use TeBo\Telegram\Chat;
use TeBo\Telegram\Response\Text;
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
        $update->getChat()->send(new Text('Replace this command!'));
        $update->getChat()->send(new Text('<code>How to replace this command</code>'));
    }
}
