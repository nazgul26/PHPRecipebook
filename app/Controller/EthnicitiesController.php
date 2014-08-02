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

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ethnicity->recursive = 0;
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
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ethnicity->create();
			if ($this->Ethnicity->save($this->request->data)) {
				$this->Session->setFlash(__('The ethnicity has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ethnicity could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Ethnicity->exists($id)) {
			throw new NotFoundException(__('Invalid ethnicity'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ethnicity->save($this->request->data)) {
				$this->Session->setFlash(__('The ethnicity has been saved.'));
				return $this->redirect(array('action' => 'index'));
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
			$this->Session->setFlash(__('The ethnicity has been deleted.'));
		} else {
			$this->Session->setFlash(__('The ethnicity could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
