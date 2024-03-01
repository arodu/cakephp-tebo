<?php
declare(strict_types=1);

namespace TeBo\Telegram\Response;

use TeBo\TeBo;
use TeBo\Telegram\Response\ResponseTrait;

class Photo implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @inheritDoc
     */
    protected array $_defaultConfig = [
        'telegramMethod' => TeBo::METHOD_SEND_PHOTO,
    ];

    protected mixed $photo;

    public function __construct($photo = '')
    {
        $this->addPhoto($photo);
    }

    public function addPhoto(mixed $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @param integer|string|null $chat_id
     * @return array
     */
    public function getData(int|string $chat_id = null): array
    {
        return array_merge(
            $this->getOptions(),
            [
                'chat_id' => $chat_id,
                'photo' => $this->photo,
            ]
        );
    }
}
