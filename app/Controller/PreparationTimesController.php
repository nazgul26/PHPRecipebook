<?php
App::uses('AppController', 'Controller');
/**
 * PreparationTimes Controller
 *
 * @property PreparationTime $PreparationTime
 * @property PaginatorComponent $Paginator
 */
class PreparationTimesController extends AppController {

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
		$this->PreparationTime->recursive = 0;
		$this->set('preparationTimes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PreparationTime->exists($id)) {
			throw new NotFoundException(__('Invalid preparation time'));
		}
		$options = array('conditions' => array('PreparationTime.' . $this->PreparationTime->primaryKey => $id));
		$this->set('preparationTime', $this->PreparationTime->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PreparationTime->create();
			if ($this->PreparationTime->save($this->request->data)) {
				$this->Session->setFlash(__('The preparation time has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The preparation time could not be saved. Please, try again.'));
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
		if (!$this->PreparationTime->exists($id)) {
			throw new NotFoundException(__('Invalid preparation time'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PreparationTime->save($this->request->data)) {
				$this->Session->setFlash(__('The preparation time has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The preparation time could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PreparationTime.' . $this->PreparationTime->primaryKey => $id));
			$this->request->data = $this->PreparationTime->find('first', $options);
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
		$this->PreparationTime->id = $id;
		if (!$this->PreparationTime->exists()) {
			throw new NotFoundException(__('Invalid preparation time'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PreparationTime->delete()) {
			$this->Session->setFlash(__('The preparation time has been deleted.'));
		} else {
			$this->Session->setFlash(__('The preparation time could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
