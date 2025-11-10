<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Enum\TelegramMethod;
use TeBo\Response\ResponseInterface;

class Response implements ResponseInterface
{
    protected TelegramMethod|string $method;
    protected array $data = [];
    protected array $httpOptions = [];

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
            ->setText($text);
    }

    /**
     * @param int $messageId El ID del mensaje a editar.
     * @return self
     */
    public static function editMessage(int $messageId): self
    {
        return static::create(TelegramMethod::EDIT_MESSAGE_TEXT)
            ->asHtml()
            ->setMessageId($messageId);
    }


    /**
     * @param int $messageId El ID del mensaje a editar.
     * @return self
     */
    public static function editKeyboard(int $messageId): self
    {
        return static::create(TelegramMethod::EDIT_MESSAGE_REPLY_MARKUP)
            ->setMessageId($messageId);
    }

    /**
     * @param string $photo
     * @return self
     */
    public static function newPhoto(string $photo): self
    {
        return static::create(TelegramMethod::SEND_PHOTO)
            ->asHtml()
            ->setPhoto($photo);
    }

    /**
     * @param string $action
     * @return self
     */
    public static function newChatAction(string $action): self
    {
        return static::create(TelegramMethod::SEND_CHAT_ACTION)
            ->setData(['action' => $action]);
    }

    /**
     * @param int $messageId
     * @return self
     */
    public static function deleteMessage(int $messageId): self
    {
        return static::create(TelegramMethod::DELETE_MESSAGE)
            ->messageId($messageId);
    }

    // Fluent setters1

    /**
     * @param array $data
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @param array $httpOptions
     * @return self
     */
    public function setHttpOptions(array $httpOptions): self
    {
        $this->httpOptions = array_merge($this->httpOptions, $httpOptions);

        return $this;
    }

    /**
     * @param int $messageId
     * @return self
     */
    public function messageId(int $messageId): self
    {
        $this->data['message_id'] = $messageId;

        return $this;
    }

    /**
     * @param array|string $text
     * @return self
     */
    public function setText(array|string $text): self
    {
        $this->data['text'] = is_string($text) ? [$text] : $text;

        return $this;
    }

    public function addText(array|string $text): self
    {
        if (!isset($this->data['text']) || !is_array($this->data['text'])) {
            $this->data['text'] = [];
        }

        if (is_string($text)) {
            $this->data['text'][] = $text;
        } else {
            $this->data['text'] = array_merge($this->data['text'], $text);
        }

        return $this;
    }

    /**
     * @param string $caption
     * @return self
     */
    public function setCaption(string $caption): self
    {
        $this->data['caption'] = $caption;
        return $this;
    }

    public function setPhoto(string $fileIdOrUrl): self
    {
        $this->data['photo'] = $fileIdOrUrl;
        return $this;
    }

    public function setMessageId(int $messageId): self
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

    public function setReplyToMessageId(int $messageId): self
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

    /**
     * @return string
     */
    public function telegramMethod(): string
    {
        if ($this->method instanceof TelegramMethod) {
            return $this->method->getMethod();
        }

        return $this->method;
    }

    /**
     * @param int|string|null $chat_id
     * @return array
     */
    public function telegramFormat(int|string|null $chat_id = null): array
    {
        $data = array_merge(['chat_id' => $chat_id], $this->data);

        if (!empty($data['text']) && is_array($data['text'])) {
            $data['text'] = implode(PHP_EOL, $data['text']);
        }

        return $data;
    }

    /**
     * @return array
     */
    public function httpOptions(): array
    {
        return $this->httpOptions ?? [];
    }
}
