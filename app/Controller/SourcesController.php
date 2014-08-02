<?php
App::uses('AppController', 'Controller');
/**
 * Sources Controller
 *
 * @property Source $Source
 * @property PaginatorComponent $Paginator
 */
class SourcesController extends AppController {

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
		$this->Source->recursive = 0;
		$this->set('sources', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Source->exists($id)) {
			throw new NotFoundException(__('Invalid source'));
		}
		$options = array('conditions' => array('Source.' . $this->Source->primaryKey => $id));
		$this->set('source', $this->Source->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Source->create();
			if ($this->Source->save($this->request->data)) {
				$this->Session->setFlash(__('The source has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The source could not be saved. Please, try again.'));
			}
		}
		$users = $this->Source->User->find('list');
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
		if (!$this->Source->exists($id)) {
			throw new NotFoundException(__('Invalid source'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Source->save($this->request->data)) {
				$this->Session->setFlash(__('The source has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The source could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Source.' . $this->Source->primaryKey => $id));
			$this->request->data = $this->Source->find('first', $options);
		}
		$users = $this->Source->User->find('list');
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
		$this->Source->id = $id;
		if (!$this->Source->exists()) {
			throw new NotFoundException(__('Invalid source'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Source->delete()) {
			$this->Session->setFlash(__('The source has been deleted.'));
		} else {
			$this->Session->setFlash(__('The source could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
