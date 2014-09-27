<?php
App::uses('AppController', 'Controller');
/**
 * Ethnicities Controller
 *
 * @property Ethnicity $Ethnicity
 * @property PaginatorComponent $Paginator
 */
class EthnicitiesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    public $paginate = array(
            'order' => array(
                'Ethnicities.name' => 'asc'
            )
        );
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Ethnicity->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('ethnicities', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Ethnicity->exists($id)) {
                throw new NotFoundException(__('Invalid ethnicity'));
        }
        $options = array('conditions' => array('Ethnicity.' . $this->Ethnicity->primaryKey => $id));
        $this->set('ethnicity', $this->Ethnicity->find('first', $options));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->Ethnicity->exists($id)) {
                throw new NotFoundException(__('Invalid ethnicity'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Ethnicity->save($this->request->data)) {
                    $this->Session->setFlash(__('The ethnicity has been saved.'), 'success', array('event' => 'saved.ethnicity'));
                    return $this->redirect(array('action' => 'edit'));
            } else {
                    $this->Session->setFlash(__('The ethnicity could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Ethnicity.' . $this->Ethnicity->primaryKey => $id));
            $this->request->data = $this->Ethnicity->find('first', $options);
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
        $this->Ethnicity->id = $id;
        if (!$this->Ethnicity->exists()) {
            throw new NotFoundException(__('Invalid ethnicity'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Ethnicity->delete()) {
            $this->Session->setFlash(__('The ethnicity has been deleted.'), 'success', array('event' => 'saved.ethnicity'));
        } else {
            $this->Session->setFlash(__('The ethnicity could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }     
 }
