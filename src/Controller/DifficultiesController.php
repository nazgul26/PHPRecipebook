<?php
namespace App\Controller;

use App\Controller\AppController;

class DifficultiesController extends AppController {

    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }
    
    public function index()
    {
        $difficulties = $this->paginate($this->Difficulties);
        $this->set(compact('difficulties'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Difficulties->exists($id)) {
            throw new NotFoundException(__('Invalid base type'));
        }

        if ($id == null) {
            $difficulty = $this->Difficulties->newEntity();
        } else {
            $difficulty = $this->Difficulties->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $difficulty = $this->Difficulties->patchEntity($difficulty, $this->request->getData());
            if ($this->Difficulties->save($difficulty)) {
                $this->Flash->success(__('The difficulty has been saved.'), 
                    ['params' => ['event' => 'saved.difficulty']]);

                return $this->redirect(array('action' => 'edit'));
            }
            $this->Flash->error(__('The difficulty could not be saved. Please, try again.'));
        }

        $this->set(compact('difficulty')); 
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $difficulty = $this->Difficulties->get($id);
        if ($this->Difficulties->delete($difficulty)) {
            $this->Flash->success(__('The difficulty has been deleted.'));
        } else {
            $this->Flash->error(__('The difficulty could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
