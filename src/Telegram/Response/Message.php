<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use TeBo\TeBo;
use TeBo\Telegram\Response\ResponseTrait;

class Message implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var array $text The text property of the message.
     */
    protected array $text = [];

    /**
     * The method used for sending the Telegram message.
     * @see https://core.telegram.org/bots/api#sendmessage
     * @var string
     */
    protected string $telegramMethod = TeBo::METHOD_SEND_MESSAGE;

    /**
     * Constructor for the Message class.
     *
     * @param string|array|null $text The text of the message.
     */
    public function __construct(string|array $text = null)
    {
        $this->addText($text);
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
    public function getData(int|string $chat_id = null): array
    {
        return array_merge(
            $this->getOptions(),
            [
                'chat_id' => $chat_id,
                'text' => $this->getText(),
            ]
        );
    }
}
