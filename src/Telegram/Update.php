<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Utility\Hash;
use InvalidArgumentException;
use TeBo\TeBoPlugin;
use TeBo\Telegram\Enum\UpdateType;
use TeBo\Telegram\Response\ResponseInterface;
use TeBo\Telegram\Trait\DataManageTrait;
use TeBo\Utility\Bot;

class Update
{
    use DataManageTrait;

    protected string|int $updateId;
    protected Chat $chat;
    protected Message $message;
    protected UpdateType $type;

    /**
     * @param array $updateData
     */
    public function __construct(array $updateData = [])
    {
        $this->setOriginalData($updateData);
        $this->updateId = ((int) $updateData['update_id']) ?? null;
        if (empty($this->updateId)) {
            Log::error('Update ID is required!', ['config' => $updateData]);
            throw new InvalidArgumentException('Update ID is required!');
        }

        Bot::debug('New update received', $updateData);

        $event = new Event(TeBoPlugin::EVENT_NEW_UPDATE, $this);
        EventManager::instance()->dispatch($event);
    }

    /**
     * Get the chat associated with the update.
     *
     * @return Chat The chat object.
     */
    public function getChat(): Chat
    {
        if (empty($this->chat)) {
            $path = $this->getType()->getChatPath();
            $chatData = Hash::get($this->getOriginalData(), $path);
            $this->chat = new Chat($chatData);
        }

        return $this->chat;
    }

    /**
     * @return Message The message object.
     */
    public function getMessage(): Message
    {
        if (empty($this->message)) {
            $path = $this->getType()->getMessagePath();
            $messageData = Hash::get($this->getOriginalData(), $path);
            $this->message = new Message($messageData);
        }

        return $this->message;
    }

    public function getType(): UpdateType
    {
        if (empty($this->type)) {
            $this->type = UpdateType::get($this->getOriginalData());
        }

        return $this->type;
    }

    /**
     * Reply to the update.
     * 
     * @param ResponseInterface $response
     * @return boolean
     */
    public function reply(ResponseInterface $response): bool
    {
        return $this->getChat()->send($response);
    }

    /**
     * Checks if the update is a command.
     *
     * @return bool Returns true if the update is a command, false otherwise.
     */
    public function isCommand(): bool
    {
        return $this->getMessage()->isCommand();
    }

    /**
     * Get the name of the command from the update.
     *
     * @return string|null The name of the command, or null if it is not a command.
     */
    public function getCommandName(): ?string
    {
        return $this->getMessage()->getCommandName();
    }
}
