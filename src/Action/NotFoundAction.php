<?php

declare(strict_types=1);

namespace TeBo\Action;

use Cake\Core\Configure;
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

        if (Configure::read('debug')) {
            $message->addText('You can change this message in <code>NotFoundAction</code> class');
        }

        $this->getChat()->send($message);
    }
}
