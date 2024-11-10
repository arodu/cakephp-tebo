<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use TeBo\TeBoPlugin;

class TextMessage extends AbstractResponse
{
    protected array $text = [];

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->setConfig('telegramMethod', TeBoPlugin::METHOD_SEND_MESSAGE);
        $this->addText($this->data ?? null);
    }

    /**
     * Resets the text property of the Message object.
     *
     * @return self
     */
    public function resetText(): self
    {
        $this->text = [];

        return $this;
    }

    /**
     * Adds text to the message.
     *
     * @param string|array|null $text The text to add. It can be a string or an array of strings.
     * @return self The updated Message object.
     */
    public function addText(string|array $text = null): self
    {
        if (is_string($text)) {
            $this->text[] = $text;
        }

        if (is_array($text)) {
            $this->text = array_merge($this->text, $text);
        }

        return $this;
    }

    /**
     * Get the text of the message.
     *
     * @return string The text of the message.
     */
    public function getText(): string
    {
        return implode("\n", $this->text);
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
