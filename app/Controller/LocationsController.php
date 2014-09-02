<?php
App::uses('AppController', 'Controller');
/**
 * Locations Controller
 *
 * @property Location $Location
 * @property PaginatorComponent $Paginator
 */
class LocationsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    
    public $paginate = array(
        'order' => array(
            'Location.name' => 'asc'
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Location->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('locations', $this->Paginator->paginate());
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->Location->exists($id)) {
                throw new NotFoundException(__('Invalid location'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Location->save($this->request->data)) {
                    $this->Session->setFlash(__('The location has been saved.'), 'success', array('event' => 'saved.location'));
                    return $this->redirect(array('action' => 'edit'));
            } else {
                    $this->Session->setFlash(__('The location could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Location.' . $this->Location->primaryKey => $id));
            $this->request->data = $this->Location->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
            $this->Location->id = $id;
            if (!$this->Location->exists()) {
                    throw new NotFoundException(__('Invalid location'));
            }
            $this->request->onlyAllow('post', 'delete');
            if ($this->Location->delete()) {
                    $this->Session->setFlash(__('The location has been deleted.'), 'success', array('event' => 'saved.location'));
            } else {
                    $this->Session->setFlash(__('The location could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'index'));
    }
    
    public function search() {
        $term = $this->request->query('term');
        if ($term)
        {
            $this->Location->recursive = 0;
            $this->Paginator->settings = $this->paginate;
            $this->set('locations', $this->Paginator->paginate("Location", array('Location.Name LIKE' => '%' . $term . '%')));
        } else {
            $this->set('locations', $this->Paginator->paginate());
        }
        $this->render('index');
    }
}
