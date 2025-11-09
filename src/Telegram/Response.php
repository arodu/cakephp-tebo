<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use TeBo\Enum\TelegramMethod;
use TeBo\Response\ResponseInterface;

class Response implements ResponseInterface
{
    protected TelegramMethod|string $method;
    protected array $data = [];
    protected array $httpOptions = []; // Para httpOptions

    protected function __construct(TelegramMethod|string $method)
    {
        $this->method = $method;
    }

    /**
     * @param TelegramMethod|string $method
     * @return self
     */
    public static function create(TelegramMethod|string $method): self
    {
        return new static($method);
    }

    /**
     * @param array|string $text Texto inicial (opcional).
     * @return self
     */
    public static function newMessage(array|string $text = ''): self
    {
        return static::create(TelegramMethod::SEND_MESSAGE)
            ->asHtml()
            ->text($text);
    }

    /**
     * @param int $messageId El ID del mensaje a editar.
     * @return self
     */
    public static function editMessage(int $messageId): self
    {
        return static::create(TelegramMethod::EDIT_MESSAGE_TEXT)
            ->asHtml()
            ->messageId($messageId);
    }


    /**
     * @param int $messageId El ID del mensaje a editar.
     * @return self
     */
    public static function editKeyboard(int $messageId): self
    {
        return static::create(TelegramMethod::EDIT_MESSAGE_REPLY_MARKUP)
            ->messageId($messageId);
    }


    public static function newPhoto(string $photo): self
    {
        return static::create(TelegramMethod::SEND_PHOTO)
            ->asHtml()
            ->photo($photo);
    }

    public static function chatAction(string $action): self
    {
        return static::create(TelegramMethod::SEND_CHAT_ACTION)
            ->data(['action' => $action]);
    }

    // Fluent setters

    public function data(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function setHttpOptions(array $httpOptions): self
    {
        $this->httpOptions = array_merge($this->httpOptions, $httpOptions);

        return $this;
    }

    public function text(array|string $text): self
    {
        if (is_array($text)) {
            $text = implode(PHP_EOL, $text);
        }

        $this->data['text'] = $text;

        return $this;
    }

    public function caption(string $caption): self
    {
        $this->data['caption'] = $caption;
        return $this;
    }

    public function photo(string $fileIdOrUrl): self
    {
        $this->data['photo'] = $fileIdOrUrl;
        return $this;
    }

    public function messageId(int $messageId): self
    {
        $this->data['message_id'] = $messageId;

        return $this;
    }

    public function asHtml(bool $html = true): self
    {
        $this->data['parse_mode'] = $html ? 'HTML' : null;

        return $this;
    }

    public function removeKeyboard(): self
    {
        $this->data['reply_markup'] = ['inline_keyboard' => []];

        return $this;
    }

    public function setInlineKeyboard(array $inlineKeyboardRows): self
    {
        $this->data['reply_markup'] = ['inline_keyboard' => $inlineKeyboardRows];

        return $this;
    }

    public function replyToMessageId(int $messageId): self
    {
        $this->data['reply_to_message_id'] = $messageId;

        return $this;
    }

    /**
     * @param boolean $force
     * @param boolean $selective
     * @param string $placeholder
     * @return self
     */
    public function setForceReply(bool $force = true, bool $selective = true, string $placeholder = ''): self
    {
        $this->data['reply_markup'] = [
            'force_reply' => $force,
            'selective' => $selective,
        ];

        if (!empty($placeholder)) {
            $this->data['reply_markup']['input_field_placeholder'] = $placeholder;
        }
        return $this;
    }

    // ResponseInterface methods

    public function telegramMethod(): string
    {
        if ($this->method instanceof TelegramMethod) {
            return $this->method->getMethod();
        }

        return $this->method;
    }

    public function telegramFormat(int|string|null $chat_id = null): array
    {
        return array_merge(['chat_id' => $chat_id], $this->data);
    }

    public function httpOptions(): array
    {
        return $this->httpOptions;
    }
}
