<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use TeBo\TeBoPlugin;

class Video extends AbstractResponse
{
    protected string $video;

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->setConfig('telegramMethod', TeBoPlugin::METHOD_SEND_VIDEO);
        $this->addVideo($this->data ?? null);
    }

    /**
     * @param mixed $photo
     * @return self
     */
    public function addVideo(mixed $video): self
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function telegramFormat(int|string|null $chat_id = null): array
    {
        return array_merge(
            $this->getConfig('options', []),
            [
                'chat_id' => $chat_id,
                'video' => $this->video,
            ]
        );
    }
}
