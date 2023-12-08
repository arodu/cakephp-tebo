<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use Cake\Core\InstanceConfigTrait;
use Cake\Http\Client\Response;
use TeBo\TeBo;
use Tebo\Telegram\Response\ResponseTrait;

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

    public function __construct(string|array $text = null)
    {
        $this->addText($text);
    }

    public function resetText(): self
    {
        $this->text = [];

        return $this;
    }

    public function addText(string|array $text): self
    {
        if (is_string($text)) {
            $this->text[] = $text;
        }

        if (is_array($text)) {
            $this->text = array_merge($this->text, $text);
        }

        return $this;
    }

    public function getText(): string
    {
        return implode("\n", $this->text);
    }

    /**
     * @param integer|string|null $chat_id
     * @return array
     */
    public function getData(int|string $chat_id = null): array
    {
        return array_merge(
            $this->getOptions(),
            [
                'chat_id' => $chat_id,
                'text' => $this->getText(),
                'parse_mode' => 'HTML',
            ]
        );
    }
}
