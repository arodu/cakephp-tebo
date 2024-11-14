<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Enum\TelegramMethod;
use TeBo\Utility\Trait\TextTrait;

class TextMessage extends AbstractResponse
{
    use TextTrait;

    protected TelegramMethod|string $method = TelegramMethod::SEND_MESSAGE;

    protected array $options = [];

    public function __construct(string|array|null $text = null, array $options = [])
    {
        $this->options = $options;
        $this->addText($text);
        $this->initialize();
    }

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Get the data for the message.
     *
     * @param int|string|null $chat_id The ID of the chat.
     * @return array The message data.
     */
    public function telegramFormat(int|string $chat_id = null): array
    {
        return array_merge(
            $this->method->getDefaultOptions(),
            $this->options,
            [
                'chat_id' => $chat_id,
                'text' => $this->getText(),
            ]
        );
    }
}
