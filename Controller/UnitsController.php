<?php

App::uses('AppController', 'Controller');
/**
 * Units Controller.
 *
 * @property Unit $Unit
 * @property PaginatorComponent $Paginator
 */
class UnitsController extends AppController
{
    public $components = ['Paginator'];

    public $paginate = [
        'order' => [
            'Unit.name' => 'asc',
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
        $this->Unit->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('units', $this->Paginator->paginate());
    }

    /**
     * view method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Unit->exists($id)) {
            throw new NotFoundException(__('Invalid unit'));
        }
        $options = ['conditions' => ['Unit.'.$this->Unit->primaryKey => $id]];
        $this->set('unit', $this->Unit->find('first', $options));
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
        if ($id != null && !$this->Unit->exists($id)) {
            throw new NotFoundException(__('Invalid unit'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Unit->save($this->request->data)) {
                $this->Session->setFlash(__('The unit has been saved.'), 'success', ['event' => 'saved.unit']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The unit could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Unit.'.$this->Unit->primaryKey => $id]];
            $this->request->data = $this->Unit->find('first', $options);
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
        $this->Unit->id = $id;
        if (!$this->Unit->exists()) {
            throw new NotFoundException(__('Invalid unit'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Unit->delete()) {
            $this->Session->setFlash(__('The unit has been deleted.'), 'success', ['event' => 'saved.unit']);
        } else {
            $this->Session->setFlash(__('The unit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
