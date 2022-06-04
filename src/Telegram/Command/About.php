<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Message\TextMessage;
use TeBo\Telegram\Chat;

class About implements CommandInterface
{
    public function help()
    {
    }

    /**
     * @param Chat $chat
     * @param array $originalData
     * @return void
     */
    public function execute(Chat $chat, array $originalData)
    {
        $chat->send(new TextMessage('Hello World from TeBo!'));
    }
}
