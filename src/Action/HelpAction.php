<?php

declare(strict_types=1);

namespace TeBo\Action;

use TeBo\Action\Action;
use TeBo\Response\HtmlMessage;
use TeBo\Telegram\Update;
use TeBo\Utility\Bot;

class HelpAction extends Action implements CommandInterface
{
    const DESCRIPTION = 'Show help message';

    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        $descriptionList = Bot::getCommandDescriptionList();

        $message = new HtmlMessage('<b>List of available commands:</b>');
        $message->addText('');
        foreach ($descriptionList as $command) {
            $message->addText('/' . $command['command'] . ' ' . $command['description']);
        }

        $update->reply($message);
    }
}
