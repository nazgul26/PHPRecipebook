<?php
App::uses('AppController', 'Controller');
/**
 * Difficulties Controller
 *
 * @property Difficulty $Difficulty
 * @property PaginatorComponent $Paginator
 */
class DifficultiesController extends AppController {

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
		$this->Difficulty->recursive = 0;
		$this->set('difficulties', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Difficulty->exists($id)) {
			throw new NotFoundException(__('Invalid difficulty'));
		}
		$options = array('conditions' => array('Difficulty.' . $this->Difficulty->primaryKey => $id));
		$this->set('difficulty', $this->Difficulty->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Difficulty->create();
			if ($this->Difficulty->save($this->request->data)) {
				$this->Session->setFlash(__('The difficulty has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The difficulty could not be saved. Please, try again.'));
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
		if (!$this->Difficulty->exists($id)) {
			throw new NotFoundException(__('Invalid difficulty'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Difficulty->save($this->request->data)) {
				$this->Session->setFlash(__('The difficulty has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The difficulty could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Difficulty.' . $this->Difficulty->primaryKey => $id));
			$this->request->data = $this->Difficulty->find('first', $options);
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
		$this->Difficulty->id = $id;
		if (!$this->Difficulty->exists()) {
			throw new NotFoundException(__('Invalid difficulty'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Difficulty->delete()) {
			$this->Session->setFlash(__('The difficulty has been deleted.'));
		} else {
			$this->Session->setFlash(__('The difficulty could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
