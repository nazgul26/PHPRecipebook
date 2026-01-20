<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

class PreparationTimesController extends AppController
{
    // Authentication required for all actions (default behavior in CakePHP 5)

    public function index()
    {
        $preparationTimes = $this->paginate($this->PreparationTimes);
        $this->set(compact('preparationTimes'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->PreparationTimes->exists($id)) {
            throw new NotFoundException(__('Invalid base type'));
        }

        if ($id == null) {
            $preparationTime = $this->PreparationTimes->newEmptyEntity();
        } else {
            $preparationTime = $this->PreparationTimes->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $preparationTime = $this->PreparationTimes->patchEntity($preparationTime, $this->request->getData());
            if ($this->PreparationTimes->save($preparationTime)) {
                $this->Flash->success(__('The preparation time has been saved.'),
                    ['params' => ['event' => 'saved.preparationTime']]);

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error(__('The preparation time could not be saved. Please, try again.'));
        }
        $this->set(compact('preparationTime'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $preparationTime = $this->PreparationTimes->get($id);
        if ($this->PreparationTimes->delete($preparationTime)) {
            $this->Flash->success(__('The preparation time has been deleted.'));
        } else {
            $this->Flash->error(__('The preparation time could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
