<?php
App::uses('AppController', 'Controller');
/**
 * Stores Controller
 *
 * @property Store $Store
 * @property PaginatorComponent $Paginator
 */
class StoresController extends AppController {

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
		$this->Store->recursive = 0;
		$this->set('stores', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Store->exists($id)) {
			throw new NotFoundException(__('Invalid store'));
		}
		$options = array('conditions' => array('Store.' . $this->Store->primaryKey => $id));
		$this->set('store', $this->Store->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Store->create();
			if ($this->Store->save($this->request->data)) {
				$this->Session->setFlash(__('The store has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The store could not be saved. Please, try again.'));
			}
		}
		$users = $this->Store->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Store->exists($id)) {
			throw new NotFoundException(__('Invalid store'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Store->save($this->request->data)) {
				$this->Session->setFlash(__('The store has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The store could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Store.' . $this->Store->primaryKey => $id));
			$this->request->data = $this->Store->find('first', $options);
		}
		$users = $this->Store->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Store->id = $id;
		if (!$this->Store->exists()) {
			throw new NotFoundException(__('Invalid store'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Store->delete()) {
			$this->Session->setFlash(__('The store has been deleted.'));
		} else {
			$this->Session->setFlash(__('The store could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
