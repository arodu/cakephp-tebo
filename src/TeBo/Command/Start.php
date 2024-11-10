<?php
declare(strict_types=1);

namespace TeBo\TeBo\Command;

use TeBo\TeBo\AbstractCommand;
use TeBo\TeBo\CommandInterface;
use TeBo\Telegram\Chat;
use TeBo\Telegram\Response\HtmlMessage;
use TeBo\Telegram\Response\TextMessage;
use TeBo\Telegram\Update;

class Start extends AbstractCommand implements CommandInterface
{
    /**
     * @param Chat $chat
     * @param array $originalData
     * @return void
     */
    public function execute(Update $update): void
    {
        $update->getChat()->send(new TextMessage('Replace this command!'));
        $update->getChat()->send(new HtmlMessage('<code>How to replace this command</code>'));
    }
}
