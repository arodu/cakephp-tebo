<?php
declare(strict_types=1);

namespace TeBo\Controller;

use Cake\Event\EventInterface;
use TeBo\Controller\AppController;
use TeBo\TeBo\Command\HelloWorld;
use TeBo\Telegram\Chat;
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
        $data = $this->getRequest()->getData();
        $update = new Update($data);

        //$command = new HelloWorld();
        //$command->execute($chat, $data);

        //Log::info(json_encode($this->getRequest()->getData()));
        //Log::info(json_encode($this->getRequest()->getQuery()));
        //  {"update_id":355796413,"message":{"message_id":13,"from":{"id":313850745,"is_bot":false,"first_name":"Alberto","last_name":"Rodriguez","username":"arodu","language_code":"en"},"chat":{"id":313850745,"first_name":"Alberto","last_name":"Rodriguez","username":"arodu","type":"private"},"date":1653924612,"text":"\/start","entities":[{"offset":0,"length":6,"type":"bot_command"}]}}
        // {"update_id":355796414,"message":{"message_id":14,"from":{"id":313850745,"is_bot":false,"first_name":"Alberto","last_name":"Rodriguez","username":"arodu","language_code":"en"},"chat":{"id":313850745,"first_name":"Alberto","last_name":"Rodriguez","username":"arodu","type":"private"},"date":1653926217,"text":"Hola mundo.."}}

        return $this->response->withStatus(200);
    }
}
