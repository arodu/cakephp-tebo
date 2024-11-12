<?php

declare(strict_types=1);

namespace TeBo\TeBo\Command;

use Cake\Core\Configure;
use TeBo\TeBo\TeBoCommand;
use TeBo\Telegram\Response\HtmlMessage;
use TeBo\Telegram\Update;

class About extends TeBoCommand
{
    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        if (Configure::read('tebo.debug')) { // this only runs if the debug mode is enabled
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

            $update->getChat()->send($message);
        }
    }
}
