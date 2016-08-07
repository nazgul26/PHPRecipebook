<?php

App::uses('AppController', 'Controller');
/**
 * Sources Controller.
 *
 * @property Source $Source
 * @property PaginatorComponent $Paginator
 */
class SourcesController extends AppController
{
    public $components = ['Paginator'];

    public $paginate = [
        'order' => [
            'Source.name' => 'asc',
        ],
    ];

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
        $this->Source->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('sources', $this->Paginator->paginate());
    }

    public function view($id = null)
    {
        if (!$this->Source->exists($id)) {
            throw new NotFoundException(__('Invalid source'));
        }
        $options = ['conditions' => ['Source.'.$this->Source->primaryKey => $id]];
        $this->set('source', $this->Source->find('first', $options));
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
        if ($id != null && !$this->Source->exists($id)) {
            throw new NotFoundException(__('Invalid source'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Source->save($this->request->data)) {
                $this->Session->setFlash(__('The source has been saved.'), 'success', ['event' => 'savedSource']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The source could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Source.'.$this->Source->primaryKey => $id]];
            $this->request->data = $this->Source->find('first', $options);
        }
        $users = $this->Source->User->find('list');
        $this->set(compact('users'));
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
        $this->Source->id = $id;
        if (!$this->Source->exists()) {
            throw new NotFoundException(__('Invalid source'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Source->delete()) {
            $this->Session->setFlash(__('The source has been deleted.'), 'success');
        } else {
            $this->Session->setFlash(__('The source could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
