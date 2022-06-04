<?php
declare(strict_types=1);

namespace TeBo\Telegram;

use Cake\Core\InstanceConfigTrait;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Exception;
use TeBo\TeBo;

class Update
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'update_id' => null,
    ];

    protected Chat $_chat;
    protected array $_originalData;

    /**
     * @param array $config
     */
    public function __construct($updateData = [])
    {
        $this->_originalData = $updateData;
        $this->setConfig($updateData);
        if (empty($this->getConfig('update_id'))) {
            throw new Exception();
        }

        $event = new Event(TeBo::EVENT_NEW_UPDATE, $this);
        EventManager::instance()->dispatch($event);
    }

    public function getOriginalData()
    {
        return $this->_originalData;
    }

    public function getChat(): Chat
    {
        if (empty($this->_chat)) {
            $this->_chat = new Chat($this->getConfig('message.chat'));
        }
        
        return $this->_chat;
    }
}