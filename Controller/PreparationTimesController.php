<?php

App::uses('AppController', 'Controller');
/**
 * PreparationTimes Controller.
 *
 * @property PreparationTime $PreparationTime
 * @property PaginatorComponent $Paginator
 */
class PreparationTimesController extends AppController
{
    public $components = ['Paginator'];

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }

    /**
     * index method.
     *
     * @return void
     */
    public function index()
    {
        $this->PreparationTime->recursive = 0;
        $this->set('preparationTimes', $this->Paginator->paginate());
    }

    /**
     * edit method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function edit($id = null)
    {
        if ($id != null && !$this->PreparationTime->exists($id)) {
            throw new NotFoundException(__('Invalid preparation time'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->PreparationTime->save($this->request->data)) {
                $this->Session->setFlash(__('The preparation time has been saved.'), 'success', ['event' => 'savedPreparationTime']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The preparation time could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['PreparationTime.'.$this->PreparationTime->primaryKey => $id]];
            $this->request->data = $this->PreparationTime->find('first', $options);
        }
    }

    /**
     * delete method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function delete($id = null)
    {
        $this->PreparationTime->id = $id;
        if (!$this->PreparationTime->exists()) {
            throw new NotFoundException(__('Invalid preparation time'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->PreparationTime->delete()) {
            $this->Session->setFlash(__('The preparation time has been deleted.'), 'success', ['event' => 'savedPreparationTime']);
        } else {
            $this->Session->setFlash(__('The preparation time could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
