<?php

App::uses('AppController', 'Controller');
/**
 * Ethnicities Controller.
 *
 * @property Ethnicity $Ethnicity
 * @property PaginatorComponent $Paginator
 */
class EthnicitiesController extends AppController
{
    public $components = ['Paginator'];
    public $paginate = [
            'order' => [
                'Ethnicities.name' => 'asc',
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
        $this->Ethnicity->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('ethnicities', $this->Paginator->paginate());
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
        if (!$this->Ethnicity->exists($id)) {
            throw new NotFoundException(__('Invalid ethnicity'));
        }
        $options = ['conditions' => ['Ethnicity.'.$this->Ethnicity->primaryKey => $id]];
        $this->set('ethnicity', $this->Ethnicity->find('first', $options));
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
        if ($id != null && !$this->Ethnicity->exists($id)) {
            throw new NotFoundException(__('Invalid ethnicity'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Ethnicity->save($this->request->data)) {
                $this->Session->setFlash(__('The ethnicity has been saved.'), 'success', ['event' => 'saved.ethnicity']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The ethnicity could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Ethnicity.'.$this->Ethnicity->primaryKey => $id]];
            $this->request->data = $this->Ethnicity->find('first', $options);
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
        $this->Ethnicity->id = $id;
        if (!$this->Ethnicity->exists()) {
            throw new NotFoundException(__('Invalid ethnicity'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Ethnicity->delete()) {
            $this->Session->setFlash(__('The ethnicity has been deleted.'), 'success', ['event' => 'saved.ethnicity']);
        } else {
            $this->Session->setFlash(__('The ethnicity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
