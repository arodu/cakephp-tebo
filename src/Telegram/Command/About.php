<?php

declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Response\Message;
use TeBo\Telegram\Update;

class About extends BaseCommand
{
    public function execute(Update $update)
    {
        $message = new Message();
        $message
            ->addText([
                '<b>About TeBo:</b>',
                '',
                'TeBo is a CakePHP plugin for Telegram Bot.',
                'It is based on the official Telegram Bot API.',
                '',
                'You can find the source code on GitHub:',
                'https://github.com/arodu/cakephp-tebo',
            ])
            ->addOptions([
                'parse_mode' => 'HTML',
            ]);

        $update->getChat()->send($message);
    }
}
