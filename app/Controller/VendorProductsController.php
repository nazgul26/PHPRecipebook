<?php
App::uses('AppController', 'Controller');
/**
 * VendorProducts Controller
 *
 * @property VendorProduct $VendorProduct
 * @property PaginatorComponent $Paginator
 */
class VendorProductsController extends AppController {

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
		$this->VendorProduct->recursive = 0;
		$this->set('vendorProducts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->VendorProduct->exists($id)) {
			throw new NotFoundException(__('Invalid vendor product'));
		}
		$options = array('conditions' => array('VendorProduct.' . $this->VendorProduct->primaryKey => $id));
		$this->set('vendorProduct', $this->VendorProduct->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->VendorProduct->create();
			if ($this->VendorProduct->save($this->request->data)) {
				$this->Session->setFlash(__('The vendor product has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vendor product could not be saved. Please, try again.'));
			}
		}
		$ingredients = $this->VendorProduct->Ingredient->find('list', 
                        array(
                            'order' => array(
                                'Ingredient.name' => 'asc'
                            )
                        ));
		$vendors = $this->VendorProduct->Vendor->find('list');
		$this->set(compact('ingredients', 'vendors'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->VendorProduct->exists($id)) {
			throw new NotFoundException(__('Invalid vendor product'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->VendorProduct->save($this->request->data)) {
				$this->Session->setFlash(__('The vendor product has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vendor product could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('VendorProduct.' . $this->VendorProduct->primaryKey => $id));
			$this->request->data = $this->VendorProduct->find('first', $options);
		}
		$ingredients = $this->VendorProduct->Ingredient->find('list');
		$vendors = $this->VendorProduct->Vendor->find('list');
		$this->set(compact('ingredients', 'vendors'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->VendorProduct->id = $id;
		if (!$this->VendorProduct->exists()) {
			throw new NotFoundException(__('Invalid vendor product'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->VendorProduct->delete()) {
			$this->Session->setFlash(__('The vendor product has been deleted.'));
		} else {
			$this->Session->setFlash(__('The vendor product could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
