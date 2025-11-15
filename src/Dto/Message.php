<?php

declare(strict_types=1);

namespace TeBo\Dto;

use TeBo\Enum\MessageType;
use TeBo\Utility\Trait\DataManageTrait;

class Message
{
    use DataManageTrait;

    protected int $id;
    protected MessageType $type;
    protected ?Message $repliedToMessage = null;
    

    public function __construct(array $messageData)
    {
        $this->setOriginalData($messageData);
        $this->id = (int) $messageData['message_id'];
        $this->type = MessageType::getFromMessage($messageData);

        if (isset($messageData['reply_to_message'])) {
            $this->repliedToMessage = new Message($messageData['reply_to_message']);
        }
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return MessageType
     */
    public function getType(): MessageType
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->get('text') ?? null;
    }

    /**
     * @return Message|null
     */
    public function getRepliedToMessage(): ?Message
    {
        return $this->repliedToMessage;
    }
}
