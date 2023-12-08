<?php
declare(strict_types=1);

namespace TeBo\Telegram\Response;

use Cake\Core\InstanceConfigTrait;
use Cake\Http\Client\Response;

class Photo implements ResponseInterface
{
    protected mixed $photo;

    protected string $telegramMethod = 'sendPhoto';

    public function __construct($photo = '')
    {
        $this->addPhoto($photo);
    }

    public function addPhoto(mixed $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getText(): string
    {
        return implode("\n", []);
    }

    public function getData(): array
    {
        return [
            'photo' => $this->photo,
        ];
    }
}
