<?php

declare(strict_types=1);

namespace TeBo\Action;

use Cake\Core\Configure;
use TeBo\Action\Action;
use TeBo\Response\HtmlMessage;

class AboutAction extends Action
{
    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        if (!Configure::read('debug')) {
            return; // this only runs if the debug mode is enabled
        }

        $message = new HtmlMessage();
        $message
            ->addText([
                '<b>About TeBo:</b>',
                '',
                'TeBo is a CakePHP plugin for Telegram Bot.',
                'It is based on the official Telegram Bot API.',
                '',
                'You can find the source code on GitHub:',
                'https://github.com/arodu/cakephp-tebo',
            ]);
        $this->getChat()->send($message);
    }
}
