<?php

declare(strict_types=1);

namespace TeBo\TeBo\Command;

use TeBo\TeBo\AbstractCommand;
use TeBo\TeBo\CommandInterface;
use TeBo\Telegram\Response\HtmlMessage;
use TeBo\Telegram\Response\Photo;
use TeBo\Telegram\Response\TextMessage;
use TeBo\Telegram\Update;

class Example extends AbstractCommand implements CommandInterface
{
    /**
     * this command is called only if tebo.debug is set to true
     * 
     * @var bool
     */
    protected bool $debug = true;

    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        //$update->getChat()->send(new TextMessage('Hello!'));
        //$update->getChat()->send(new TextMessage([
        //    'Text Message',
        //    '',
        //    'This is an example of a text message.',
        //]));
        //$update->getChat()->send(new HtmlMessage([
        //    '<b>HTML Message</b>',
        //    '',
        //    'This is an example of an HTML message.',
        //    'You can use HTML basic tags to format the text.',
        //    'example: <b>bold</b>, <i>italic</i>, <a href="https://example.com">link</a>',
        //    'Go to telegram api documentation for more information.',
        //]));

        dd(file_get_contents(TEBO_CORE_PATH . DS . '/resources/tebo.jpg'));


        //$update->getChat()->send(new Photo(, 'This is a placeholder image.'));
    }
}
