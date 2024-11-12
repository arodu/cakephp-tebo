<?php

declare(strict_types=1);

namespace TeBo\TeBo\Command;

use Cake\Core\Configure;
use TeBo\TeBo\TeBoCommand;
use TeBo\Telegram\Response\HtmlMessage;
use TeBo\Telegram\Response\Photo;
use TeBo\Telegram\Response\TextMessage;
use TeBo\Telegram\Update;

class Example extends TeBoCommand
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
        if (Configure::read('tebo.debug')) { // this only runs if the debug mode is enabled
            $update->getChat()->send(new TextMessage('Hello!'));
            $update->getChat()->send(new HtmlMessage([
                '<b>This is an example of a html message.</b>',
                '',
                'Check the file <code>vendor/arodu/tebo/src/TeBo/Command/Example.php</code> to see how it works.',
            ]));

            // send an html message example
            //$update->getChat()->send(new HtmlMessage([
            //    '<b>HTML Message</b>',
            //    '',
            //    'This is an example of an HTML message.',
            //    'You can use HTML basic tags to format the text.',
            //    'example: <b>bold</b>, <i>italic</i>, <a href="https://example.com">link</a>',
            //    'Go to telegram api documentation for more information.',
            //]));

            // send a photo example
            //$file = fopen(TEBO_CORE_PATH . DS . '/resources/tebo.jpg', 'rb');
            //$photo = new Photo($file, 'This is a placeholder image.');
            //$update->getChat()->send($photo);

            // send a photo example with caption
            //$photo = new Photo('https://placehold.it/300x200', 'This is a placeholder image.');
            //$update->getChat()->send($photo);
        }
    }
}
