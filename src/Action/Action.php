<?php

declare(strict_types=1);

namespace TeBo\Action;

use Cake\Core\InstanceConfigTrait;
use TeBo\Telegram\Chat;
use TeBo\Dto\Update;
use TeBo\Dto\User;

abstract class Action implements ActionInterface
{
    use InstanceConfigTrait;

    protected array $_defaultConfig = [];
    protected ?Update $update;
    protected ?Chat $chat;
    protected ?User $user;

    /**
     * Action constructor.
     */
    public function __construct(?Update $update = null, array $config = [])
    {
        $this->setConfig($config);
        if (!empty($update)) {
            $this->setUpdate($update);
        }
        $this->initialize();
    }

    /**
     * Initialize the action.
     */
    public function initialize()
    {
        // This method is called after the constructor
    }

    /**
     * @param Update $update
     * @return self
     */
    public function setUpdate(Update $update): self
    {
        $this->update = $update;

        return $this;
    }

    /**
     * @return Update
     */
    public function getUpdate(): Update
    {
        if (empty($this->update)) {
            throw new \RuntimeException('The update is not set');
        }

        return $this->update;
    }

    /**
     * @param Chat $chat
     * @return self
     */
    public function setChat(Chat $chat): self
    {
        $this->chat = $chat;

        return $this;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        if (empty($this->chat)) {
            $this->chat = $this->getUpdate()?->getChat();
        }

        return $this->chat;
    }

    /**
     * @param User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        if (empty($this->user)) {
            $this->user = $this->getUpdate()?->getUser();
        }

        return $this->user;
    }

    /**
     * The command description for the help command.
     *
     * @return string|null
     */
    public static function description(): ?string
    {
        return null;
    }
}
