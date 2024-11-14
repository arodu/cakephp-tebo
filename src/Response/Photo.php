<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Enum\TelegramMethod;
use TeBo\Utility\Trait\TextTrait;

class Photo extends AbstractResponse implements ResponseInterface
{
    use TextTrait;

    protected $photo;
    protected TelegramMethod|string $method = TelegramMethod::SEND_PHOTO;
    protected array $options = [];

    public function __construct($photo = null, string|array|null $caption = null, array $options = [])
    {
        $this->options = $options;
        if ($photo) {
            $this->addPhoto($photo);
        }
        if ($caption) {
            $this->addText($caption);
        }
        $this->initialize();
    }

    /**
     * @param string $photo
     * @return self
     */
    public function addPhoto($photo): self
    {
        $this->photo = $photo;

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
                'photo' => $this->photo,
                'caption' => $this->getText() ?? null,
            ]
        );
    }
}
