<?php
declare(strict_types=1);

namespace TeBo\Telegram\Response;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function getText(): string;
}
