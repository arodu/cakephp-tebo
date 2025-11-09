<?php

declare(strict_types=1);

namespace TeBo\Dto;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Utility\Hash;
use InvalidArgumentException;
use TeBo\Action\Command\MessageCommand;
use TeBo\TeBoPlugin;
use TeBo\Enum\UpdateType;
use TeBo\Response\ResponseInterface;
use TeBo\Service\ApiService;
use TeBo\Telegram\Chat;
use TeBo\Utility\Trait\DataManageTrait;

class Update
{
    use DataManageTrait;

    protected string|int $updateId;
    protected ApiService $apiService;
    protected Chat $chat;
    protected Message $message;
    protected UpdateType $type;
    protected ?CallbackQuery $callbackQuery = null;

    /**
     * @param array $updateData
     */
    public function __construct(array $updateData = [], ApiService $apiService)
    {
        $this->setOriginalData($updateData);
        $this->apiService = $apiService;
        $this->updateId = ((int) $updateData['update_id']) ?? null;
        if (empty($this->updateId)) {
            Log::error('Update ID is required!', ['config' => $updateData]);
            throw new InvalidArgumentException('Update ID is required!');
        }

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
            $this->chat = new Chat($chatData, $this->apiService);
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

    public function getCallbackQuery(): CallbackQuery
    {
        if (empty($this->callbackQuery)) {
            $callbackData = Hash::get($this->getOriginalData(), 'callback_query');
            
            if (empty($callbackData)) {
                throw new \RuntimeException('Se intentó acceder a callback_query, pero no existe en este Update.');
            }

            $this->callbackQuery = new CallbackQuery($callbackData);
        }

        return $this->callbackQuery;
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

    public function getCommandName(): ?string
    {
        $commandMessage = new MessageCommand($this->getMessage());

        return $commandMessage->getCommandName() ?? null;
    }
}
