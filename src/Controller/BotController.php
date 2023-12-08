<?php
declare(strict_types=1);

namespace TeBo\Controller;

use Cake\Event\EventInterface;
use Exception;
use TeBo\Controller\AppController;
use TeBo\TeBo\Command\HelloWorld;
use TeBo\Telegram\Chat;
use TeBo\Telegram\Command\CommandFactory;
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
    
            if ($update->isCommand()) {
                $command = CommandFactory::build($update);
                $command->execute($update);
            }
        } catch (Exception $e) {
            debug($e);
        }

        return $this->response->withStatus(200);
    }
}
