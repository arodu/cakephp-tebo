<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use TeBo\TeBoPlugin;

class Photo extends AbstractResponse
{
    protected string $photo;

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->setConfig('telegramMethod', TeBoPlugin::METHOD_SEND_PHOTO);
        $this->addPhoto($this->data ?? null);
    }

    /**
     * @param mixed $photo
     * @return self
     */
    public function addPhoto(mixed $photo): self
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
            ]
        );
    }
}
