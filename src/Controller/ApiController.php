<?php
declare(strict_types=1);

namespace TeBo\Controller;

use Cake\Log\Log;
use TeBo\Controller\AppController;

/**
 * Api Controller
 *
 * @method \TeBo\Model\Entity\Api[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApiController extends AppController
{
    /**
     * webhook method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function webhook()
    {
        Log::debug(json_encode($this->getRequest()->getData()));
        Log::debug(json_encode($this->getRequest()->getQuery()));

        return $this->response->withStatus(200);
    }
}
