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
use TeBo\Utility\Bot;

class Update
{
    protected string $updateId;
    protected array $originalData;
    protected Chat $chat;
    protected Message $message;
    protected UpdateType $type;

    /**
     * @param array $updateData
     */
    public function __construct(array $updateData = [])
    {
        $this->originalData = $updateData;
        $this->type = UpdateType::get($updateData);
        $this->updateId = $updateData['update_id'] ?? null;
        if (empty($this->updateId)) {
            Log::error('Update ID is required!', ['config' => $updateData]);
            throw new InvalidArgumentException('Update ID is required!');
        }

        Bot::debug('New update received', $updateData);
        $event = new Event(TeBoPlugin::EVENT_NEW_UPDATE, $this);
        EventManager::instance()->dispatch($event);
    }

    /**
     * Get the original data of the update.
     *
     * @return mixed The original data of the update.
     */
    public function getOriginalData()
    {
        return $this->originalData;
    }

    /**
     * @param string $path
     * @param mixed $default
     * @return void
     */
    public function get(string $path, mixed $default = null)
    {
        return Hash::get($this->getOriginalData(), $path, $default);
    }

    /**
     * Get the chat associated with the update.
     *
     * @return Chat The chat object.
     */
    public function getChat(): Chat
    {
        if (empty($this->chat)) {
            $path = $this->type->getChatPath();
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
            $path = $this->type->getMessagePath();
            $messageData = Hash::get($this->getOriginalData(), $path);
            $this->message = new Message($messageData);
        }

        return $this->message;
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
