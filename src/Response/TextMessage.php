<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Response\LegacyResponseBuilder;
use TeBo\Utility\Trait\TextTrait;

/**
 * @deprecated use \TeBo\Response\Response::newMessage()->asHtml(false) instead
 */
class TextMessage implements ResponseInterface
{
    use TextTrait;

    protected LegacyResponseBuilder $builder;

    public function __construct(string|array|null $text = null, array $options = [])
    {
        $this->addText($text);

        $this->builder = LegacyResponseBuilder::newMessage((string)$this->getText())->asHtml(false);

        if (isset($options['reply_markup'])) {
            $this->builder->setRawReplyKeyboard($options['reply_markup']);
        }

        $this->builder->addOptions($options);
    }

    public function telegramMethod(): string
    {
        return $this->builder->telegramMethod();
    }

    public function telegramFormat(int|string|null $chat_id = null): array
    {
        $this->builder->text((string)$this->getText());

        return $this->builder->telegramFormat($chat_id);
    }

    public function httpOptions(): array
    {
        return $this->builder->httpOptions();
    }
}
