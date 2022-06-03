<?php
declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Core\InstanceConfigTrait;
use Exception;
use TeBo\Message\MessageInterface;
use TeBo\Utility\Bot;

class Chat
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'id' => null,
    ];

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);

        if (empty($this->getConfig('id'))) {
            throw new Exception();
        }
    }

    /**
     * @param MessageInterface $message
     * @return boolean
     */
    public function send(MessageInterface $message): bool
    {
        return Bot::sendMessage([
            'chat_id' => $this->getConfig('id'),
            'text' => $message->getText(),
        ]);
    }
}
