<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Chat;
use TeBo\Telegram\Update;

interface CommandInterface
{
    public function __construct(array $args = []);
    public function help();
    public function execute(Update $update);
    //public function send();
}
