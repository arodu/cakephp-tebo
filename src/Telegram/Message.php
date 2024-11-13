<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Utility\Hash;
use TeBo\Telegram\Enum\MessageType;

class Message
{
    protected string $id;
    protected MessageType $type;
    protected array $originalData;

    public function __construct(array $messageData)
    {
        $this->originalData = $messageData;
        $this->id = $messageData['message_id'];
        $this->type = MessageType::getFromMessage($messageData);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): MessageType
    {
        return $this->type;
    }

    public function getOriginalData(): array
    {
        return $this->originalData;
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

        $entities = Hash::get($this->originalData, 'entities');
        $commandEntity = array_filter($entities, fn($entity) => $entity['type'] === 'bot_command');
        $commandEntity = reset($commandEntity);

        return substr($this->originalData['text'], $commandEntity['offset'] + 1, $commandEntity['length'] - 1);
    }
}
