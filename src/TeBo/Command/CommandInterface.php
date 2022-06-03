<?php
declare(strict_types=1);

namespace TeBo\TeBo\Command;

use TeBo\Telegram\Chat;

interface CommandInterface
{
    public function help();
    public function execute(Chat $chat, array $originalData);
}
