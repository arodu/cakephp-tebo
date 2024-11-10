<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use Cake\Core\InstanceConfigTrait;
use TeBo\TeBoPlugin;

abstract class AbstractResponse implements ResponseInterface
{
    use InstanceConfigTrait;

    protected array $_defaultConfig = [
        'telegramMethod' => null,
        'options' => [],
    ];

    /**
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * @return string|null
     */
    public function telegramMethod(): string
    {
        $telegramMethod = $this->getConfig('telegramMethod');

        if (empty($telegramMethod)) {
            throw new \InvalidArgumentException('Telegram method is required!');
        }

        return $telegramMethod;
    }
}
