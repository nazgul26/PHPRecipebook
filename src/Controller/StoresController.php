<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

class StoresController extends AppController
{
    // Authentication required for all actions (default behavior in CakePHP 5)

    public function index()
    {
        $stores = $this->paginate($this->Stores);
        $this->set(compact('stores'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Stores->exists($id)) {
            throw new NotFoundException(__('Invalid store'));
        }

        if ($id == null) {
            $store = $this->Stores->newEmptyEntity();
        } else {
            $store = $this->Stores->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $store = $this->Stores->patchEntity($store, $this->request->getData());
            if ($this->Stores->save($store)) {
                $this->Flash->success(__('The store has been saved.'),
                ['params' => ['event' => 'saved.stored']]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store could not be saved. Please, try again.'));
        }
        $this->set(compact('store'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $store = $this->Stores->get($id);
        if ($this->Stores->delete($store)) {
            $this->Flash->success(__('The store has been deleted.'));
        } else {
            $this->Flash->error(__('The store could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
