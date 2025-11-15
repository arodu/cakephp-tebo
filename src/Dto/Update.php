<?php

declare(strict_types=1);

namespace TeBo\Dto;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Utility\Hash;
use InvalidArgumentException;
use TeBo\Dto\Message\Command;
use TeBo\Dto\Message\Document;
use TeBo\Dto\Message\Photo;
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
    protected User $user;
    protected ?CallbackQuery $callbackQuery = null;

    protected UpdateType $type;

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

    public function getMessage(): Message
    {
        if (empty($this->message)) {
            $path = $this->getType()->getMessagePath();
            $messageData = Hash::get($this->getOriginalData(), $path);

            if (empty($messageData)) {
                throw new \RuntimeException(__('Cannot find message data at path: {0}', $path));
            }

            if ($this->isCommand($messageData)) {
                $this->message = new Command($messageData);
            } elseif (isset($messageData['photo'])) {
                $this->message = new Photo($messageData);
            } elseif (isset($messageData['document'])) {
                $this->message = new Document($messageData);
            } else {
                $this->message = new Message($messageData);
            }
        }

        return $this->message;
    }

    /**
     * @return \TeBo\Dto\User The user object.
     */
    public function getUser(): User
    {
        if (empty($this->user)) {
            $path = $this->getType()->getUserPath();
            $userData = Hash::get($this->getOriginalData(), $path);
            $this->user = new User($userData);
        }

        return $this->user;
    }

    /**
     * @return \TeBo\Dto\CallbackQuery The callback query object.
     */
    public function getCallbackQuery(): ?CallbackQuery
    {
        if ($this->getType() !== UpdateType::CALLBACK_QUERY) {
            return null;
        }

        if (empty($this->callbackQuery)) {
            $callbackData = Hash::get($this->getOriginalData(), 'callback_query');

            if (empty($callbackData)) {
                throw new InvalidArgumentException('Callback query data is required for CALLBACK_QUERY updates.');
            }

            $this->callbackQuery = new CallbackQuery($callbackData);
        }

        return $this->callbackQuery;
    }

    /**
     * @return UpdateType The update type.
     */
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
     * @param array $messageData
     * @return boolean
     */
    public function isCommand(Message|array $messageData): bool
    {
        if ($messageData instanceof Message) {
            $messageData = $messageData->getOriginalData();
        }

        $entities = $messageData['entities'] ?? [];
        foreach ($entities as $entity) {
            if ($entity['type'] === 'bot_command' && $entity['offset'] === 0) {
                return true;
            }
        }

        return false;
    }
}
