<?php

declare(strict_types=1);

namespace TeBo\Action\Command;

use Cake\Core\Configure;
use Cake\Log\Log;
use TeBo\Action\Action;
use TeBo\Action\Command\MessageCommandTrait;
use TeBo\Response\HtmlMessage;

class NotFoundAction extends Action
{
    use MessageCommandTrait;

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $message = new HtmlMessage(__('Command <code>{0}</code> not found', $this->getMessageCommand()->getCommandName()));
        Log::warning(__('Command {0} not found', $this->getMessageCommand()->getCommandName()), 'tebo');

        if (Configure::read('debug')) {
            $message->addText('You can change this message in <code>NotFoundAction</code> class');
        }

        $this->getChat()->send($message);
    }
}
