<?php
App::uses('AppController', 'Controller');
/**
 * Restaurants Controller
 *
 * @property Restaurant $Restaurant
 * @property PaginatorComponent $Paginator
 */
class RestaurantsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    
    public $paginate = array(
        'order' => array(
            'Restaurant.name' => 'asc'
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Restaurant->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('restaurants', $this->Paginator->paginate());
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->Restaurant->exists($id)) {
                throw new NotFoundException(__('Invalid restaurant'));
        }
        if ($this->request->is(array('post', 'put'))) {
                if ($this->Restaurant->save($this->request->data)) {
                        $this->Session->setFlash(__('The restaurant has been saved.'), 'success', array('event' => 'saved.restaurant'));
                        return $this->redirect(array('action' => 'edit'));
                } else {
                        $this->Session->setFlash(__('The restaurant could not be saved. Please, try again.'));
                }
        } else {
                $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
                $this->request->data = $this->Restaurant->find('first', $options);
        }
        $priceRanges = $this->Restaurant->PriceRange->find('list');
        $users = $this->Restaurant->User->find('list');
        $this->set(compact('priceRanges', 'users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Restaurant->id = $id;
        if (!$this->Restaurant->exists()) {
                throw new NotFoundException(__('Invalid restaurant'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Restaurant->delete()) {
                $this->Session->setFlash(__('The restaurant has been deleted.'), 'success', array('event' => 'saved.restaurant'));
        } else {
                $this->Session->setFlash(__('The restaurant could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function search() {
        $term = $this->request->query('term');
        if ($term)
        {
            $this->Restaurant->recursive = 0;
            $this->Paginator->settings = $this->paginate;
            $this->set('restaurants', $this->Paginator->paginate("Restaurant", array('Restaurant.Name LIKE' => '%' . $term . '%')));
        } else {
            $this->set('restaurants', $this->Paginator->paginate());
        }
        $this->render('index');
    }
}
