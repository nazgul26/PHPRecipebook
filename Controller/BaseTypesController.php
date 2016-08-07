<?php

App::uses('AppController', 'Controller');
/**
 * BaseTypes Controller.
 *
 * @property BaseType $BaseType
 * @property PaginatorComponent $Paginator
 */
class BaseTypesController extends AppController
{
    /**
     * Components.
     *
     * @var array
     */
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
        $this->BaseType->recursive = 0;
        $this->set('baseTypes', $this->Paginator->paginate());
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
        if ($id != null && !$this->BaseType->exists($id)) {
            throw new NotFoundException(__('Invalid base type'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->BaseType->save($this->request->data)) {
                $this->Session->setFlash(__('The base type has been saved.'), 'success', ['event' => 'saved.baseType']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The base type could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['BaseType.'.$this->BaseType->primaryKey => $id]];
            $this->request->data = $this->BaseType->find('first', $options);
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
        $this->BaseType->id = $id;
        if (!$this->BaseType->exists()) {
            throw new NotFoundException(__('Invalid base type'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->BaseType->delete()) {
            $this->Session->setFlash(__('The base type has been deleted.'), 'success', ['event' => 'saved.baseType']);
        } else {
            $this->Session->setFlash(__('The base type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
