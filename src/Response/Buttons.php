<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Utility\Trait\RegisterListTrait;

class Buttons extends TextMessage implements ResponseInterface
{
    use RegisterListTrait;

    /**
     * @param string|array|null $text The text of the message.
     * @param array $buttons The buttons to add.
     * @param array $options The options of the message.
     */
    public function __construct(string|array|null $text = null, array $buttons = [], array $options = [])
    {
        parent::__construct($text, $options);
        $this->options = $options;
        $this->addText($text);
        $this->addButtons($buttons);
        $this->initialize();
    }

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->options = array_merge($this->options, ['parse_mode' => 'HTML']);
    }

    /**
     * Add a button to the message.
     *
     * @param string $text The text of the button.
     * @param string $callback_data The callback data of the button.
     * @return self
     */
    public function addButton(string $text, string $callback_data): self
    {
        $this->registerItem([
            'text' => $text,
            'callback_data' => $callback_data,
        ]);

        return $this;
    }

    /**
     * Add multiple buttons to the message.
     *
     * @param array $buttons The buttons to add.
     * @return self
     */
    public function addButtons(array $buttons): self
    {
        foreach ($buttons as $button) {
            $this->addButton($button['text'], $button['callback_data']);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function telegramFormat(int|string|null $chat_id = null): array
    {
        return array_merge(
            $this->options,
            [
                'chat_id' => $chat_id,
                'text' => $this->getText(),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        $this->registerList(),
                    ],
                ]),
            ]
        );
    }
}
