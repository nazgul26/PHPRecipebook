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
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }
    
    public function isAuthorized($user) {
        // Allow limited access to this controller
        if (in_array($this->action, array('complete'))) {
            return true;
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }
    
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

    public function edit($id = null) {
        if ($id != null && !$this->Vendor->exists($id)) {
            throw new NotFoundException(__('Invalid vendor'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Vendor->save($this->request->data)) {
                    $this->Session->setFlash(__('The vendor has been saved.'), 'success');
                    return $this->redirect(array('action' => 'index'));
            } else {
                    $this->Session->setFlash(__('The vendor could not be saved. Please, try again.'));
            }
        } else if ($id != null) {
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
                $this->Session->setFlash(__('The vendor has been deleted.'), 'success');
        } else {
                $this->Session->setFlash(__('The vendor could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    } 
}
