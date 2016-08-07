<?php

App::uses('AppController', 'Controller');
/**
 * Stores Controller.
 *
 * @property Store $Store
 * @property PaginatorComponent $Paginator
 */
class StoresController extends AppController
{
    public $components = ['Paginator'];

    public function index()
    {
        $this->Store->recursive = 0;
        $this->set('stores', $this->Paginator->paginate());
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Store->exists($id)) {
            throw new NotFoundException(__('Invalid store'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Store->save($this->request->data)) {
                $this->Session->setFlash(__('The store has been saved.'), 'success');

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash(__('The store could not be saved. Please, try again.'));
            }
        } elseif ($id != null) {
            $options = ['conditions' => ['Store.'.$this->Store->primaryKey => $id]];
            $this->request->data = $this->Store->find('first', $options);
        }
    }

    public function delete($id = null)
    {
        $this->Store->id = $id;
        if (!$this->Store->exists()) {
            throw new NotFoundException(__('Invalid store'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Store->delete()) {
            $this->Session->setFlash(__('The store has been deleted.'), 'success');
        } else {
            $this->Session->setFlash(__('The store could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
