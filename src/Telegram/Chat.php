<?php
declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Core\InstanceConfigTrait;
use InvalidArgumentException;
use TeBo\Message\MessageInterface;
use TeBo\Telegram\Response\ResponseInterface;
use TeBo\Utility\Bot;

class Chat
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'id' => null,
    ];

    protected $_lastResult = null;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);

        if (empty($this->getConfig('id'))) {
            throw new InvalidArgumentException('Chat ID is required!');
        }
    }

    /**
     * @param MessageInterface $message
     * @return boolean
     */
    public function send(ResponseInterface $message): bool
    {
        $this->_lastResult = Bot::sendMessage([
            'chat_id' => $this->getConfig('id'),
            'text' => $message->getText(),
        ]);

        return $this->_lastResult['ok'] ?? false;
    }
}
