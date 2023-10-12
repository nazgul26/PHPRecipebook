<?php
namespace App\Controller;

use App\Controller\AppController;


class SourcesController extends AppController
{
    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $sources = $this->paginate($this->Sources);
        $this->set(compact('sources'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Sources->exists($id)) {
            throw new NotFoundException(__('Invalid price range'));
        }

        if ($id == null) {
            $source = $this->Sources->newEmptyEntity();
        } else {
            $source = $this->Sources->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $source = $this->Sources->patchEntity($source, $this->request->getData());
            if ($this->Sources->save($source)) {
                $this->Flash->success(__('The source has been saved.'), 
                ['params' => ['event' => 'saved.source']]);

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error(__('The price range could not be saved. Please, try again.'));
        }
        $this->set(compact('source'));
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $source = $this->Sources->get($id);
        if ($this->Sources->delete($source)) {
            $this->Flash->success(__('The source has been deleted.'));
        } else {
            $this->Flash->error(__('The source could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
