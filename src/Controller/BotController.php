<?php

declare(strict_types=1);

namespace TeBo\Controller;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Exception;
use TeBo\Action\ActionFactory;
use TeBo\Controller\AppController;
use TeBo\Dto\Update;
use TeBo\Service\ApiService;
use TeBo\TeBoPlugin;

/**
 * Bot Controller
 */
class BotController extends AppController
{
    /**
     * webhook method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function webhook()
    {
        try {
            $apiService = new ApiService();
            $update = new Update($this->getRequest()->getData(), $apiService);

            $action = ActionFactory::createOrFail($update);

            $event = new Event(TeBoPlugin::EVENT_BEFORE_ACTION, $this, ['action' => $action, 'update' => $update]);
            EventManager::instance()->dispatch($event);

            if (!$event->isStopped()) {
                $action->execute();

                $event = new Event(TeBoPlugin::EVENT_AFTER_ACTION, $this, ['action' => $action, 'update' => $update]);
                EventManager::instance()->dispatch($event);
            }

            return $this->response->withStatus(200);
        } catch (Exception $e) {
            Log::error($e->getMessage() . ': with update: ' . json_encode($update->getOriginalData()), ['exception' => $e]);

            return $this->response->withStatus(200);
        }
    }
}
