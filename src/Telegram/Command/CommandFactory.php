<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Message\TextMessage;
use TeBo\Telegram\Chat;

class CommandFactory implements CommandInterface
{
    public static function build(string $text)
    {
        debug($text);
    }
}
