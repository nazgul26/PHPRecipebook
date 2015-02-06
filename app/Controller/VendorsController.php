<?php
App::uses('AppController', 'Controller');
/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class VendorsController extends AppController {

    public $components = array('Paginator');


    public function index() {
            $this->Vendor->recursive = 0;
            $this->set('vendors', $this->Paginator->paginate());
    }

    public function view($id = null) {
            if (!$this->Vendor->exists($id)) {
                    throw new NotFoundException(__('Invalid vendor'));
            }
            $options = array('conditions' => array('Vendor.' . $this->Vendor->primaryKey => $id));
            $this->set('vendor', $this->Vendor->find('first', $options));
    }

    public function add() {
            if ($this->request->is('post')) {
                    $this->Vendor->create();
                    if ($this->Vendor->save($this->request->data)) {
                            $this->Session->setFlash(__('The vendor has been saved.'));
                            return $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The vendor could not be saved. Please, try again.'));
                    }
            }
    }

    public function edit($id = null) {
        if (!$this->Vendor->exists($id)) {
                throw new NotFoundException(__('Invalid vendor'));
        }
        if ($this->request->is(array('post', 'put'))) {
                if ($this->Vendor->save($this->request->data)) {
                        $this->Session->setFlash(__('The vendor has been saved.'));
                        return $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The vendor could not be saved. Please, try again.'));
                }
        } else {
                $options = array('conditions' => array('Vendor.' . $this->Vendor->primaryKey => $id));
                $this->request->data = $this->Vendor->find('first', $options);
        }
    }

    public function delete($id = null) {
        $this->Vendor->id = $id;
        if (!$this->Vendor->exists()) {
                throw new NotFoundException(__('Invalid vendor'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Vendor->delete()) {
                $this->Session->setFlash(__('The vendor has been deleted.'));
        } else {
                $this->Session->setFlash(__('The vendor could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function complete($id=null) {
        if (!$this->Vendor->exists($id)) {
            throw new NotFoundException(__('Invalid vendor'));
        }
        if ($this->request->is(array('post', 'put'))) {
            echo "<pre>";
            foreach ($this->request->data['VendorProduct'] as $key=>$product) 
            {
                //echo "Key: " . $key . " Code: " . $product['code'];
                echo print_r($product);
                if ($product['code'] == ""){
                    //echo "removing: " . $product['code'];
                    unset($this->request->data['VendorProduct'][$key]);
                }
                
            }
            
            //echo print_r($this->request->data);
            echo "</pre>";
            if ($this->Vendor->VendorProduct->saveAll($this->request->data['VendorProduct'])) {
                $this->Session->setFlash(__('The vendor data has been saved.'), 'success');
                //return $this->redirect(array('controller'=> 'shoppinglists', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The vendor could not be saved. Please, try again.'));
            }
        }
    }  
}
