<?php

App::uses('AppController', 'Controller');
/**
 * Locations Controller.
 *
 * @property Location $Location
 * @property PaginatorComponent $Paginator
 */
class LocationsController extends AppController
{
    public $components = ['Paginator'];

    public $paginate = [
        'order' => [
            'Location.name' => 'asc',
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
        $this->Location->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('locations', $this->Paginator->paginate());
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
        if ($id != null && !$this->Location->exists($id)) {
            throw new NotFoundException(__('Invalid location'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Location->save($this->request->data)) {
                $this->Session->setFlash(__('The location has been saved.'), 'success', ['event' => 'saved.location']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The location could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Location.'.$this->Location->primaryKey => $id]];
            $this->request->data = $this->Location->find('first', $options);
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
        $this->Location->id = $id;
        if (!$this->Location->exists()) {
            throw new NotFoundException(__('Invalid location'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Location->delete()) {
            $this->Session->setFlash(__('The location has been deleted.'), 'success', ['event' => 'saved.location']);
        } else {
            $this->Session->setFlash(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $term = $this->request->query('term');
        if ($term) {
            $this->Location->recursive = 0;
            $this->Paginator->settings = $this->paginate;
            $this->set('locations', $this->Paginator->paginate('Location', ['Location.Name LIKE' => '%'.$term.'%']));
        } else {
            $this->set('locations', $this->Paginator->paginate());
        }
        $this->render('index');
    }
}
