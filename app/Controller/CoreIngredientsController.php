<?php
App::uses('AppController', 'Controller');
/**
 * CoreIngredients Controller
 *
 * @property CoreIngredient $CoreIngredient
 * @property PaginatorComponent $Paginator
 */
class CoreIngredientsController extends AppController {

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
		$this->CoreIngredient->recursive = 0;
		$this->set('coreIngredients', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CoreIngredient->exists($id)) {
			throw new NotFoundException(__('Invalid core ingredient'));
		}
		$options = array('conditions' => array('CoreIngredient.' . $this->CoreIngredient->primaryKey => $id));
		$this->set('coreIngredient', $this->CoreIngredient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CoreIngredient->create();
			if ($this->CoreIngredient->save($this->request->data)) {
				$this->Session->setFlash(__('The core ingredient has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The core ingredient could not be saved. Please, try again.'));
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
		if (!$this->CoreIngredient->exists($id)) {
			throw new NotFoundException(__('Invalid core ingredient'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CoreIngredient->save($this->request->data)) {
				$this->Session->setFlash(__('The core ingredient has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The core ingredient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CoreIngredient.' . $this->CoreIngredient->primaryKey => $id));
			$this->request->data = $this->CoreIngredient->find('first', $options);
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
		$this->CoreIngredient->id = $id;
		if (!$this->CoreIngredient->exists()) {
			throw new NotFoundException(__('Invalid core ingredient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CoreIngredient->delete()) {
			$this->Session->setFlash(__('The core ingredient has been deleted.'));
		} else {
			$this->Session->setFlash(__('The core ingredient could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
