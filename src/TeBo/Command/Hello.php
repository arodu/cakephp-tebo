<?php
declare(strict_types=1);

namespace TeBo\TeBo\Command;

use Cake\Core\Configure;
use TeBo\TeBo\CommandInterface;
use TeBo\Telegram\Response\TextMessage;
use TeBo\Telegram\Update;

class Hello implements CommandInterface
{
    /**
     * @inheritDoc
     */
    public function help(): string
    {
        return __('No help available');
    }

    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        if (Configure::read('tebo.debug')) { // this only runs if the debug mode is enabled
            $update->getChat()->send(new TextMessage('Hello World from TeBo!'));
        }
    }
}
