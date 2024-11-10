<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

interface ResponseInterface
{
    /**
     * @param integer|string|null $chat_id
     * @return array
     */
    public function outputData(int|string|null $chat_id = null): array;

    /**
     * @return string|null
     */
    public function telegramMethod(): string;
}
