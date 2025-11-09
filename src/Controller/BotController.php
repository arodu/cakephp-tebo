<?php

declare(strict_types=1);

namespace TeBo\Controller;

use Cake\Log\Log;
use Exception;
use TeBo\Action\ActionFactory;
use TeBo\Controller\AppController;
use TeBo\Dto\Update;
use TeBo\Service\ApiService;

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
            $apiService = new ApiService();
            $update = new Update($this->getRequest()->getData(), $apiService);

            $action = ActionFactory::createOrFail($update);
            $action->execute($update);

            return $this->response->withStatus(200);
        } catch (Exception $e) {
            Log::error($e->getMessage() . ': with update: ' . json_encode($update->getOriginalData()));

            return $this->response->withStatus(200);
        }
    }
}
