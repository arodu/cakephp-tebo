<?php
declare(strict_types=1);

namespace TeBo\TeBo\Command;

use Cake\Core\Configure;
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
        $update->getChat()->send(new TextMessage('Start command executed'));

        if (Configure::read('tebo.debug')) { // this only runs if the debug mode is enabled
            $update->getChat()->send(new HtmlMessage([
                'your chat id is: <i>' . $update->getChat()->getId() . '</i>',
                'you can use this id to send messages to this chat',
                'you can also use this id to send messages to other chats',
                'to change to command, can creat new command file in <code>src/TeBo/Command</code>',
            ]));
        }
    }
}
