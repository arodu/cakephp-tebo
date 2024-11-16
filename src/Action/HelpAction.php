<?php

declare(strict_types=1);

namespace TeBo\Action;

use TeBo\Action\Action;
use TeBo\Response\HtmlMessage;
use TeBo\Telegram\Update;
use TeBo\Utility\Bot;

class HelpAction extends Action
{
    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return __('Show help message');
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $descriptionList = Bot::getCommandDescriptionList();

        $message = new HtmlMessage('<b>List of available commands:</b>');
        $message->addText('');
        foreach ($descriptionList as $command) {
            $message->addText('/' . $command['command'] . ' ' . $command['description']);
        }

        $this->getChat()->send($message);
    }
}
