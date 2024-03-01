<?php
declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Core\InstanceConfigTrait;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Log\Log;
use InvalidArgumentException;
use TeBo\TeBo;

class Update
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'update_id' => null,
    ];

    protected Chat $chat;
    protected array $_originalData;

    /**
     * @param array $config
     */
    public function __construct($updateData = [])
    {
        $this->_originalData = $updateData;
        $this->setConfig($updateData);
        if (empty($this->getConfig('update_id'))) {
            Log::error('Update ID is required!', ['config' => $updateData]);
            throw new InvalidArgumentException('Update ID is required!');
        }

        $event = new Event(TeBo::EVENT_NEW_UPDATE, $this);
        EventManager::instance()->dispatch($event);
    }

    /**
     * Get the original data of the update.
     *
     * @return mixed The original data of the update.
     */
    public function getOriginalData()
    {
        return $this->_originalData;
    }

    /**
     * Get the chat associated with the update.
     *
     * @return Chat The chat object.
     */
    public function getChat(): Chat
    {
        if (empty($this->chat)) {
            $this->chat = new Chat($this->getConfig('message.chat'));
        }
        
        return $this->chat;
    }

    /**
     * Checks if the update is a command.
     *
     * @return bool Returns true if the update is a command, false otherwise.
     */
    public function isCommand(): bool
    {
        $messageEntity = $this->getConfig('message.entities.0', null);
        $isCommand = $messageEntity['type'] === 'bot_command' && $messageEntity['offset'] === 0;
        if (!empty($messageEntity) && $isCommand) {
            return true;
        }

        return false;
    }

    /**
     * Get the name of the command from the update.
     *
     * @return string|null The name of the command, or null if it is not a command.
     */
    public function getCommandName(): ?string
    {
        if (!$this->isCommand()) {
            return null;
        }

        $messageEntity = $this->getConfig('message.entities.0');
        $text = $this->getConfig('message.text');
        $commandName = substr($text, $messageEntity['offset'], $messageEntity['length']);

        return trim($commandName, ' /');
    }

    /**
     * Returns the parameters of the command if the update is a command.
     *
     * @return array|null The parameters of the command, or null if the update is not a command.
     */
    public function getCommandParams(): ?array
    {
        if (!$this->isCommand()) {
            return null;
        }

        return [];
    }

}