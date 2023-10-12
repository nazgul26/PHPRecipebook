<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * VendorProducts Controller
 *
 * @property \App\Model\Table\VendorProductsTable $VendorProducts
 * @method \App\Model\Entity\VendorProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VendorProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Ingredients', 'Vendors', 'Users'],
        ];
        $vendorProducts = $this->paginate($this->VendorProducts);

        $this->set(compact('vendorProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Vendor Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendorProduct = $this->VendorProducts->get($id, [
            'contain' => ['Ingredients', 'Vendors', 'Users'],
        ]);

        $this->set(compact('vendorProduct'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vendorProduct = $this->VendorProducts->newEmptyEntity();
        if ($this->request->is('post')) {
            $vendorProduct = $this->VendorProducts->patchEntity($vendorProduct, $this->request->getData());
            if ($this->VendorProducts->save($vendorProduct)) {
                $this->Flash->success(__('The vendor product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor product could not be saved. Please, try again.'));
        }
        $ingredients = $this->VendorProducts->Ingredients->find('list', ['limit' => 200])->all();
        $vendors = $this->VendorProducts->Vendors->find('list', ['limit' => 200])->all();
        $users = $this->VendorProducts->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('vendorProduct', 'ingredients', 'vendors', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendor Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vendorProduct = $this->VendorProducts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendorProduct = $this->VendorProducts->patchEntity($vendorProduct, $this->request->getData());
            if ($this->VendorProducts->save($vendorProduct)) {
                $this->Flash->success(__('The vendor product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor product could not be saved. Please, try again.'));
        }
        $ingredients = $this->VendorProducts->Ingredients->find('list', ['limit' => 200])->all();
        $vendors = $this->VendorProducts->Vendors->find('list', ['limit' => 200])->all();
        $users = $this->VendorProducts->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('vendorProduct', 'ingredients', 'vendors', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendorProduct = $this->VendorProducts->get($id);
        if ($this->VendorProducts->delete($vendorProduct)) {
            $this->Flash->success(__('The vendor product has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
