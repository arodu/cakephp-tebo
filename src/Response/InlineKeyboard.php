<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Utility\Trait\RegisterListTrait;

/**
 * @deprecated use \TeBo\Telegram\Response::newMessage()->setInlineKeyboard(...) instead.
 */
class InlineKeyboard extends HtmlMessage implements ResponseInterface
{
    use RegisterListTrait;

    public function __construct(string|array|null $text = null, array $buttons = [], array $options = [])
    {
        parent::__construct($text, $options);
        $this->addButtons($buttons);
    }

    public function addButton(string $text, string $callback_data): self
    {
        $this->registerItem([
            'text' => $text,
            'callback_data' => $callback_data,
        ]);

        return $this;
    }

    public function addButtons(array $buttons): self
    {
        foreach ($buttons as $button) {
            $this->addButton($button['text'], $button['callback_data']);
        }

        return $this;
    }

    public function telegramFormat(int|string|null $chat_id = null): array
    {
        $buttonRows = [$this->registerList()];

        $this->builder
            ->text((string)$this->getText())
            ->setInlineKeyboard($buttonRows);

        return $this->builder->telegramFormat($chat_id);
    }
}
