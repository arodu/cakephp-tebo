<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use TeBo\TeBoPlugin;

class Photo extends AbstractResponse implements ResponseInterface
{
    use TextTrait;

    protected string $photo;

    public function __construct(?string $photo = null, string|array|null $caption = null, array $config = [])
    {
        $this->setConfig($config);
        $this->setConfig('telegramMethod', TeBoPlugin::METHOD_SEND_PHOTO);
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
    public function addPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function outputData(int|string|null $chat_id = null): array
    {
        return array_merge(
            $this->getConfig('options', []),
            [
                'chat_id' => $chat_id,
                'photo' => $this->photo,
                'caption' => $this->getText() ?? null,
            ]
        );
    }
}
