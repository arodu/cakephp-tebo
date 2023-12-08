<?php
declare(strict_types=1);

namespace TeBo\Telegram\Response;

interface ResponseInterface
{
    /**
     * @param integer|string|null $chat_id
     * @return array
     */
    public function getData(int|string $chat_id = null): array;

    /**
     * @return string
     */
    public function getTelegramMethod(): string;
}
