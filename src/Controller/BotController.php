<?php
declare(strict_types=1);

namespace TeBo\Controller;

use Cake\Log\Log;
use Exception;
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
            $command = TeBoCommandFactory::build($update);

            if ($command) {
                $command->execute($update);
            } else {
                Log::notice('Command not found!', ['update' => $update->getOriginalData()]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return $this->response->withStatus(200);
    }
}
