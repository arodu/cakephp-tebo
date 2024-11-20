<?php

declare(strict_types=1);

namespace TeBo\Action\Command;

use Cake\Core\Configure;
use TeBo\Action\Action;
use TeBo\Response\HtmlMessage;
use TeBo\Response\TextMessage;
use TeBo\Telegram\Update;

class StartAction extends Action
{
    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return __('Start command');
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $this->getChat()->send(new TextMessage(__('Start command executed!')));

        if (Configure::read('debug')) { // this only runs if the debug mode is enabled
            $this->getChat()->send(new HtmlMessage([
                'your chat id is: <i>' . $this->getChat()->getId() . '</i>',
                'you can use this id to send messages to this chat',
                'you can also use this id to send messages to other chats',
                'to change to command, can creat new command file in <code>src/TeBo/Command</code>',
            ]));
        }
    }
}
