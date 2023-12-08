<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Response\ResponseText;
use TeBo\Telegram\Update;

class About extends BaseCommand
{
    public function help()
    {
    }

    public function execute(Update $update)
    {
        $message = new ResponseText([
            '<b>About TeBo:</b>',
            '',
            'TeBo is a Telegram Bot Framework for PHP.',
            'It is based on the official Telegram Bot API.',
            'You can find the source code on GitHub:',
            'https://github.com/arodu/cakephp-tebo',
        ]);

        $update->getChat()->send($message);
    }
}
