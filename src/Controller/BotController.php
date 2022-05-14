<?php
declare(strict_types=1);

namespace TeBo\Controller;

use TeBo\Controller\AppController;

/**
 * Bot Controller
 *
 * @method \TeBo\Model\Entity\Bot[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BotController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        //$bot = $this->paginate($this->Bot);
        //$this->set(compact('bot'));
        return $this->response->withStatus(200);
    }

    /**
     * View method
     *
     * @param string|null $id Bot id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bot = $this->Bot->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('bot'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bot = $this->Bot->newEmptyEntity();
        if ($this->request->is('post')) {
            $bot = $this->Bot->patchEntity($bot, $this->request->getData());
            if ($this->Bot->save($bot)) {
                $this->Flash->success(__('The bot has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bot could not be saved. Please, try again.'));
        }
        $this->set(compact('bot'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bot id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bot = $this->Bot->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bot = $this->Bot->patchEntity($bot, $this->request->getData());
            if ($this->Bot->save($bot)) {
                $this->Flash->success(__('The bot has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bot could not be saved. Please, try again.'));
        }
        $this->set(compact('bot'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bot id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bot = $this->Bot->get($id);
        if ($this->Bot->delete($bot)) {
            $this->Flash->success(__('The bot has been deleted.'));
        } else {
            $this->Flash->error(__('The bot could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
