<?php
App::uses('AppController', 'Controller');
/**
 * Settings Controller
 *
 * @property Setting $Setting
 * @property PaginatorComponent $Paginator
 */
class SettingsController extends AppController {

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
		$this->Setting->recursive = 0;
		$this->set('settings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Setting->exists($id)) {
			throw new NotFoundException(__('Invalid setting'));
		}
		$options = array('conditions' => array('Setting.' . $this->Setting->primaryKey => $id));
		$this->set('setting', $this->Setting->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Setting->create();
			if ($this->Setting->save($this->request->data)) {
				$this->Session->setFlash(__('The setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The setting could not be saved. Please, try again.'));
			}
		}
		$users = $this->Setting->User->find('list');
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
		if (!$this->Setting->exists($id)) {
			throw new NotFoundException(__('Invalid setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Setting->save($this->request->data)) {
				$this->Session->setFlash(__('The setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The setting could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Setting.' . $this->Setting->primaryKey => $id));
			$this->request->data = $this->Setting->find('first', $options);
		}
		$users = $this->Setting->User->find('list');
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
		$this->Setting->id = $id;
		if (!$this->Setting->exists()) {
			throw new NotFoundException(__('Invalid setting'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Setting->delete()) {
			$this->Session->setFlash(__('The setting has been deleted.'));
		} else {
			$this->Session->setFlash(__('The setting could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
