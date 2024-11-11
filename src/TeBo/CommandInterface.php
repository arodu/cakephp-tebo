<?php
declare(strict_types=1);

namespace TeBo\TeBo;

use TeBo\Telegram\Chat;
use TeBo\Telegram\Update;

interface CommandInterface
{
    /**
     * @return string|null
     */
    public function help(): ?string;

    /**
     * @param Update $update
     * @return void
     */
    public function execute(Update $update): void;
}
