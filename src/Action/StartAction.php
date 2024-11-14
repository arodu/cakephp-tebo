<?php
declare(strict_types=1);

namespace TeBo\Action;

use Cake\Core\Configure;
use TeBo\Action\CommandInterface;
use TeBo\Action\Action;
use TeBo\Response\HtmlMessage;
use TeBo\Response\TextMessage;
use TeBo\Telegram\Update;

class StartAction extends Action implements CommandInterface
{
    const DESCRIPTION = 'Start command';

    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        $update->reply(new TextMessage(__('Start command executed!')));

        if (Configure::read('debug')) { // this only runs if the debug mode is enabled
            $update->reply(new HtmlMessage([
                'your chat id is: <i>' . $update->getChat()->getId() . '</i>',
                'you can use this id to send messages to this chat',
                'you can also use this id to send messages to other chats',
                'to change to command, can creat new command file in <code>src/TeBo/Command</code>',
            ]));
        }
    }
}
