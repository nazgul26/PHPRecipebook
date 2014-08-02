<?php
App::uses('AppController', 'Controller');
/**
 * PriceRanges Controller
 *
 * @property PriceRange $PriceRange
 * @property PaginatorComponent $Paginator
 */
class PriceRangesController extends AppController {

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
		$this->PriceRange->recursive = 0;
		$this->set('priceRanges', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PriceRange->exists($id)) {
			throw new NotFoundException(__('Invalid price range'));
		}
		$options = array('conditions' => array('PriceRange.' . $this->PriceRange->primaryKey => $id));
		$this->set('priceRange', $this->PriceRange->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PriceRange->create();
			if ($this->PriceRange->save($this->request->data)) {
				$this->Session->setFlash(__('The price range has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The price range could not be saved. Please, try again.'));
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
		if (!$this->PriceRange->exists($id)) {
			throw new NotFoundException(__('Invalid price range'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PriceRange->save($this->request->data)) {
				$this->Session->setFlash(__('The price range has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The price range could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PriceRange.' . $this->PriceRange->primaryKey => $id));
			$this->request->data = $this->PriceRange->find('first', $options);
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
		$this->PriceRange->id = $id;
		if (!$this->PriceRange->exists()) {
			throw new NotFoundException(__('Invalid price range'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PriceRange->delete()) {
			$this->Session->setFlash(__('The price range has been deleted.'));
		} else {
			$this->Session->setFlash(__('The price range could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
