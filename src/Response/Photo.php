<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Enum\TelegramMethod;
use TeBo\Telegram\LegacyResponseBuilder;
use TeBo\Utility\Trait\TextTrait;

/**
 * @deprecated use \TeBo\Telegram\Response::newPhoto() instead
 */
class Photo implements ResponseInterface
{
    use TextTrait;

    protected LegacyResponseBuilder $builder;
    protected $photo;

    public function __construct($photo = null, string|array|null $caption = null, array $options = [])
    {
        if ($photo) {
            $this->addPhoto($photo);
        }
        if ($caption) {
            $this->addText($caption);
        }
        
        $this->builder = LegacyResponseBuilder::newPhoto(string)$this->photo)
            ->caption((string)$this->getText())
            ->asHtml(true);

        if (isset($options['reply_markup'])) {
            $this->builder->setRawReplyKeyboard($options['reply_markup']);
        }
        $this->builder->addOptions($options);
    }

    public function addPhoto($photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    public function telegramMethod(): string
    {
        return $this->builder->telegramMethod();
    }

    public function telegramFormat(int|string|null $chat_id = null): array
    {
        $this->builder
            ->photo((string)$this->photo)
            ->caption((string)$this->getText());

        return $this->builder->telegramFormat($chat_id);
    }

    public function httpOptions(): array
    {
        return $this->builder->httpOptions();
    }
}