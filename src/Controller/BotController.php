<?php

declare(strict_types=1);

namespace TeBo\Controller;

use Cake\Core\Configure;
use Cake\Log\Log;
use Exception;
use PSpell\Config;
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
            $data = $this->getRequest()->getData();
            $update = new Update($data);
            $command = TeBoCommandFactory::build($update) ?? TeBoCommandFactory::getDefaultCommand() ?? null;

            if (!$command) {
                Log::notice('Command not found!', ['update' => $update->getOriginalData()]);
                return $this->response->withStatus(200);
            }

            if (!$command->allowExecute()) {
                Log::notice('Command not allowed!', ['update' => $update->getOriginalData()]);
                return $this->response->withStatus(200);
            }

            $command->execute($update);

            return $this->response->withStatus(200);
        } catch (Exception $e) {
            Log::error($e->getMessage() . ': ' . json_encode($update->getOriginalData()));

            return $this->response->withStatus(200);
        }
    }
}
