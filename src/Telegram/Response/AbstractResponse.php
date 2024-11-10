<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use Cake\Core\InstanceConfigTrait;
use TeBo\TeBoPlugin;

abstract class AbstractResponse implements ResponseInterface
{
    use InstanceConfigTrait;

    protected array $_defaultConfig = [
        'telegramMethod' => TeBoPlugin::METHOD_SEND_MESSAGE,
        'options' => [],
    ];

    protected mixed $data;

    public function __construct(mixed $data = null, array $config = [])
    {
        $this->setConfig($config);
        $this->addData($data);
        $this->initialize();
    }

    public function addData(mixed $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function initialize(): void
    {
    }

    /**
     * @return string|null
     */
    public function telegramMethod(): string
    {
        return $this->getConfig('telegramMethod');
    }
}
