<?php
App::uses('AppController', 'Controller');
/**
 * VendorProducts Controller
 *
 * @property VendorProduct $VendorProduct
 * @property PaginatorComponent $Paginator
 */
class VendorProductsController extends AppController {


    public $components = array('Paginator', 'RequestHandler');

    // Filter to hide ingredients of other users
    public $filterConditions = array();
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.
        
        $this->filterConditions = array('VendorProduct.user_id' => $this->Auth->user('id'));
    }
    
    public function isAuthorized($user) {
        if (in_array($this->action, array('edit', 'delete')) && isset($this->request->params['pass'][0])) {
            $productId = (int) $this->request->params['pass'][0];

            if ($this->User->isEditor($user) || $this->VendorProduct->isOwnedBy($productId, $user['id'])) {
                return true;
            }
            else {
                $this->Session->setFlash(__('Not Vendor Product Owner'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function index() {
        $this->VendorProduct->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('vendorProducts', $this->Paginator->paginate('VendorProduct', $this->filterConditions));
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
    
    public function add($vendorId, $ingredientId) {
        $this->edit(null);
        if ($this->request->is(array('get', 'put'))) {
            $this->request->data['VendorProduct']['ingredient_id'] = $ingredientId;
            $this->request->data['VendorProduct']['vendor_id'] = $vendorId;       
        }
        $this->render('edit_dialog');
    }
    
    public function refresh($id) {    
        $this->request->data = $this->VendorProduct->findAllByIngredientId($id);
    }

    public function delete($id = null) {
        $this->VendorProduct->id = $id;
        if (!$this->VendorProduct->exists()) {
                throw new NotFoundException(__('Invalid vendor product'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->VendorProduct->delete()) {
                $this->Session->setFlash(__('The vendor product has been deleted.'), 'success');
        } else {
                $this->Session->setFlash(__('The vendor product could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}
