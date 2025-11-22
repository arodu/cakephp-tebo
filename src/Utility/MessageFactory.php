<?php

declare(strict_types=1);

namespace TeBo\Utility;

use TeBo\Dto\Message;
use TeBo\Dto\Message\Command;
use TeBo\Dto\Message\Document;
use TeBo\Dto\Message\Photo;
use TeBo\Dto\Message\Voice;

class MessageFactory
{
    /**
     * @param array $messageData
     * @return Message
     */
    public static function create(array $messageData): Message
    {
        return match (true) {
            static::isCommand($messageData) => new Command($messageData),
            isset($messageData['photo']) => new Photo($messageData),
            isset($messageData['document']) => new Document($messageData),
            isset($messageData['voice']) => new Voice($messageData),
            default => new Message($messageData),
        };
    }

    /**
     * @param array $messageData
     * @return boolean
     */
    private static function isCommand(array $messageData): bool
    {
        $entities = $messageData['entities'] ?? [];
        foreach ($entities as $entity) {
            if ($entity['type'] === 'bot_command' && $entity['offset'] === 0) {
                return true;
            }
        }

        return false;
    }
}
