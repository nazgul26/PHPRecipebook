<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

/**
 * PriceRanges Controller
 *
 * @property \App\Model\Table\PriceRangesTable $PriceRanges
 *
 * @method \App\Model\Entity\PriceRange[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PriceRangesController extends AppController
{
    // Authentication required for all actions (default behavior in CakePHP 5)

    public function index()
    {
        $priceRanges = $this->paginate($this->PriceRanges);

        $this->set(compact('priceRanges'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->PriceRanges->exists($id)) {
            throw new NotFoundException(__('Invalid price range'));
        }

        if ($id == null) {
            $priceRange = $this->PriceRanges->newEmptyEntity();
        } else {
            $priceRange = $this->PriceRanges->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $priceRange = $this->PriceRanges->patchEntity($priceRange, $this->request->getData());
            if ($this->PriceRanges->save($priceRange)) {
                $this->Flash->success(__('The price range has been saved.'),
                ['params' => ['event' => 'saved.priceRange']]);

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error(__('The price range could not be saved. Please, try again.'));
        }
        $this->set(compact('priceRange'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $priceRange = $this->PriceRanges->get($id);
        if ($this->PriceRanges->delete($priceRange)) {
            $this->Flash->success(__('The price range has been deleted.'));
        } else {
            $this->Flash->error(__('The price range could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
