<?php
declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Core\InstanceConfigTrait;
use Cake\Log\Log;
use InvalidArgumentException;
use TeBo\Telegram\Response\ResponseInterface;
use TeBo\Utility\Bot;

class Chat
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'id' => null,
    ];

    
    protected $lastResult = null;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);

        if (empty($this->getConfig('id'))) {
            Log::error('Chat ID is required!', ['config' => $config]);
            throw new InvalidArgumentException('Chat ID is required!');
        }
    }

    public function getId(): ?int
    {
        return $this->getConfig('id');
    }

    /**
     * @param ResponseInterface $response
     * @return boolean
     */
    public function send(ResponseInterface $response): bool
    {
        $method = $response->telegramMethod();

        if (empty($method)) {
            Log::error('Telegram method is required!', ['response' => $response]);
            throw new InvalidArgumentException('Telegram method is required!');
        }

        $this->lastResult = Bot::$method($response->telegramFormat($this->getConfig('id')), $response->httpOptions());

        return $this->lastResult['ok'] ?? false;
    }

    /**
     * Get the last result of the chat.
     *
     * @return array|null The last result of the chat.
     */
    public function getLastResult(): ?array
    {
        return $this->lastResult;
    }
}
