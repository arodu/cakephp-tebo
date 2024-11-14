<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Utility\Hash;
use TeBo\Enum\MessageType;
use TeBo\Utility\Trait\DataManageTrait;

class Message
{
    use DataManageTrait;

    protected int $id;
    protected MessageType $type;
    

    public function __construct(array $messageData)
    {
        $this->setOriginalData($messageData);
        $this->id = (int) $messageData['message_id'];
        $this->type = MessageType::getFromMessage($messageData);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): MessageType
    {
        return $this->type;
    }

    public function isCommand(): bool
    {
        return $this->type->is(MessageType::GROUP_COMMAND);
    }

    public function getCommandName(): ?string
    {
        if (!$this->isCommand()) {
            return null;
        }

        $entities = Hash::get($this->getOriginalData(), 'entities');
        $commandEntity = array_filter($entities, fn($entity) => $entity['type'] === 'bot_command');
        $commandEntity = reset($commandEntity);

        return substr($this->get('text'), $commandEntity['offset'] + 1, $commandEntity['length'] - 1);
    }
}
