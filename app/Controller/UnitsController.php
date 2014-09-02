<?php
App::uses('AppController', 'Controller');
/**
 * Units Controller
 *
 * @property Unit $Unit
 * @property PaginatorComponent $Paginator
 */
class UnitsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public $paginate = array(
        'order' => array(
            'Unit.name' => 'asc'
        )
    );
    
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Unit->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('units', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Unit->exists($id)) {
                throw new NotFoundException(__('Invalid unit'));
        }
        $options = array('conditions' => array('Unit.' . $this->Unit->primaryKey => $id));
        $this->set('unit', $this->Unit->find('first', $options));
    }
    
    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->Unit->exists($id)) {
                throw new NotFoundException(__('Invalid unit'));
        }
        if ($this->request->is(array('post', 'put'))) {
                if ($this->Unit->save($this->request->data)) {
                        $this->Session->setFlash(__('The unit has been saved.'), 'success', array('event' => 'saved.location'));
                        return $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The unit could not be saved. Please, try again.'));
                }
        } else {
                $options = array('conditions' => array('Unit.' . $this->Unit->primaryKey => $id));
                $this->request->data = $this->Unit->find('first', $options);
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
        $this->Unit->id = $id;
        if (!$this->Unit->exists()) {
                throw new NotFoundException(__('Invalid unit'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Unit->delete()) {
                $this->Session->setFlash(__('The unit has been deleted.'), 'success', array('event' => 'saved.location'));
        } else {
                $this->Session->setFlash(__('The unit could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }   
    
    public function search() {
        $term = $this->request->query('term');
        if ($term)
        {
            $this->Location->recursive = 0;
            $this->Paginator->settings = $this->paginate;
            $this->set('units', $this->Paginator->paginate("Unit", array('Unit.Name LIKE' => '%' . $term . '%')));
        } else {
            $this->set('units', $this->Paginator->paginate());
        }
        $this->render('index');
    }
 }
