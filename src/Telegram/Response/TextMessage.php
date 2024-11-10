<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use TeBo\TeBoPlugin;

class TextMessage extends AbstractResponse
{
    use TextTrait;

    protected array $text = [];

    public function __construct(string|array|null $text = null, array $config = [])
    {
        $this->setConfig($config);
        $this->setConfig('telegramMethod', TeBoPlugin::METHOD_SEND_MESSAGE);
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
    public function outputData(int|string $chat_id = null): array
    {
        return array_merge(
            $this->getConfig('options', []),
            [
                'chat_id' => $chat_id,
                'text' => $this->getText(),
            ]
        );
    }
}
