<?php
declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Core\InstanceConfigTrait;
use Exception;
use TeBo\Message\MessageInterface;
use TeBo\Utility\Bot;

class OutputMessage
{
    use InstanceConfigTrait;

    public const TYPE_TEXT = 'text';
    public const TYPE_PHOTO = 'photo';
    public const TYPE_VIDEO = 'video';

    protected $_defaultConfig = [
        'chat_id' => null,
        'type' => null,
        'text' => null,
    ];

    public function send(): void
    {
        switch($this->getConfig('type')) {
            case self::TYPE_TEXT:
                return $this->sendText();
                //return Bot::sendMessage([
                //    'chat_id' => $this->getConfig('id'),
                //    'text' => $this->getConfig('text'),
                //]);
                break;
        }
    }

    public function sendText(?string $text = null, ?string $chat_id = null, array $optionals = [])
    {
        if (empty($text)) {
            $text = $this->getConfig('text', null);
            if (empty($text)) {
                throw new Exception("Error Processing Request", 1);
            }
        }

        if (empty($chat_id)) {
            $chat_id = $this->getConfig('$chat_id', null);
            if (empty($chat_id)) {
                throw new Exception("Error Processing Request", 1);
            }
        }

        $parameters = array_merge(
            $optionals,
            [
                'chat_id' => $chat_id,
                'text' => $text,
            ]
        );

        return Bot::sendMessage($parameters);
    }
}