<?php
declare(strict_types=1);

namespace TeBo\Telegram\Message;

interface MessageInterface
{
    /**
     * @return string
     */
    public function getText(): string;
}
