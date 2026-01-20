<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

class VendorsController extends AppController
{
    // Authentication required for all actions (default behavior in CakePHP 5)

    public function isAuthorized($user): bool
    {
        // Allow limited access to this controller
        $action = $this->request->getParam('action');
        if (in_array($action, array('complete'))) {
            return true;
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $vendors = $this->paginate($this->Vendors);

        $this->set(compact('vendors'));
    }

    public function view($id = null)
    {
        $vendor = $this->Vendors->get($id, contain: ['VendorProducts']);

        $this->set('vendor', $vendor);
    }

    public function add()
    {
        $vendor = $this->Vendors->newEmptyEntity();
        if ($this->request->is('post')) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData());
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $this->set(compact('vendor'));
    }

    public function edit($id = null)
    {
        $vendor = $this->Vendors->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData());
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $this->set(compact('vendor'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendor = $this->Vendors->get($id);
        if ($this->Vendors->delete($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
