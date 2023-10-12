<?php
namespace App\Controller;

use App\Controller\AppController;

class BaseTypesController extends AppController
{
    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }

    public function index()
    {
        $baseTypes = $this->paginate($this->BaseTypes);
        $this->set(compact('baseTypes'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->BaseTypes->exists($id)) {
            throw new NotFoundException(__('Invalid base type'));
        }

        if ($id == null) {
            $baseType = $this->BaseTypes->newEmptyEntity();
        } else {
            $baseType = $this->BaseTypes->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $baseType = $this->BaseTypes->patchEntity($baseType, $this->request->getData());
            if ($this->BaseTypes->save($baseType)) {
                $this->Flash->success(__('The base type has been saved.'), 
                    ['params' => ['event' => 'saved.baseType']]);

                return $this->redirect(array('action' => 'edit'));
            }
            $this->Flash->error(__('The base type could not be saved. Please, try again.'));
        }

        $this->set(compact('baseType')); 
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $baseType = $this->BaseTypes->get($id);
        if ($this->BaseTypes->delete($baseType)) {
            $this->Flash->success(__('The base type has been deleted.'));
        } else {
            $this->Flash->error(__('The base type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
