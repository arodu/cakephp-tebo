<?php

declare(strict_types=1);

namespace TeBo\Controller;

use Cake\Core\Configure;
use Cake\Log\Log;
use Exception;
use PSpell\Config;
use TeBo\Action\ActionFactory;
use TeBo\Controller\AppController;
use TeBo\TeBo\CommandFactory as TeBoCommandFactory;
use TeBo\Telegram\Update;

/**
 * Api Controller
 *
 * @method \TeBo\Model\Entity\Api[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
            $update = new Update($this->getRequest()->getData());

            $action = ActionFactory::createOrFail($update);
            $action->execute($update);

            return $this->response->withStatus(200);
        } catch (Exception $e) {
            Log::error($e->getMessage() . ': with update: ' . json_encode($update->getOriginalData()));

            return $this->response->withStatus(200);
        }
    }
}
