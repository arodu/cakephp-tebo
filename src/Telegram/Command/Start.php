<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Chat;
use TeBo\Telegram\Response\Message;
use TeBo\Telegram\Update;

class Start extends BaseCommand
{
    /**
     * @param Chat $chat
     * @param array $originalData
     * @return void
     */
    public function execute(Update $update)
    {
        $update->getChat()->send(new Message('Replace this command!'));
        $update->getChat()->send(new Message('<code>How to replace this command</code>'));
    }
}
