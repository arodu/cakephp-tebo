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

    public function __construct(string|array $text = '')
    {
        $this->addText($text);
    }

    public function resetText(): Message
    {
        $this->text = [];

        return $this;
    }

    public function addText(string|array $text): Message
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

    public function getData(int|string $chat_id = null): array
    {
        return array_merge([
            'chat_id' => $chat_id,
            'text' => $this->getText(),
        ], $this->getOptions());
    }
}
