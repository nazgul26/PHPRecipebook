<?php
App::uses('AppController', 'Controller');
/**
 * VendorProducts Controller
 *
 * @property VendorProduct $VendorProduct
 * @property PaginatorComponent $Paginator
 */
class VendorProductsController extends AppController {


    public $components = array('Paginator');


    public function index() {
            $this->VendorProduct->recursive = 0;
            $this->set('vendorProducts', $this->Paginator->paginate());
    }

    public function edit($id = null) {
        if ($id != null && !$this->VendorProduct->exists($id)) {
                throw new NotFoundException(__('Invalid vendor product'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['VendorProduct']['user_id'] = $this->Auth->user('id');
            
            if ($this->VendorProduct->save($this->request->data)) {
                $this->Session->setFlash(__('The vendor product has been saved.'), 'success', array('event' => 'saved.product'));
                //return $this->redirect(array('action' => 'add'));
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
    
    public function add($ingredientId, $vendorId) {
        $this->edit(null);
        if ($this->request->is(array('get', 'put'))) {
            $this->request->data['VendorProduct']['ingredient_id'] = $ingredientId;
            $this->request->data['VendorProduct']['vendor_id'] = $vendorId;       
        }
        $this->render('edit_dialog');
    }

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
    }
}
