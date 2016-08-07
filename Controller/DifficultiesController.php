<?php

App::uses('AppController', 'Controller');
/**
 * Difficulties Controller.
 *
 * @property Difficulty $Difficulty
 * @property PaginatorComponent $Paginator
 */
class DifficultiesController extends AppController
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
        $this->Difficulty->recursive = 0;
        $this->set('difficulties', $this->Paginator->paginate());
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
        if ($id != null && !$this->Difficulty->exists($id)) {
            throw new NotFoundException(__('Invalid difficulty'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Difficulty->save($this->request->data)) {
                $this->Session->setFlash(__('The difficulty has been saved.'), 'success', ['event' => 'savedDifficulty']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The difficulty could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Difficulty.'.$this->Difficulty->primaryKey => $id]];
            $this->request->data = $this->Difficulty->find('first', $options);
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
        $this->Difficulty->id = $id;
        if (!$this->Difficulty->exists()) {
            throw new NotFoundException(__('Invalid difficulty'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Difficulty->delete()) {
            $this->Session->setFlash(__('The difficulty has been deleted.'), 'success');
        } else {
            $this->Session->setFlash(__('The difficulty could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
