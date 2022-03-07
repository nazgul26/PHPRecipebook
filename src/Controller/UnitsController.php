<?php
namespace App\Controller;

use App\Controller\AppController;

class UnitsController extends AppController
{
    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }

    public function index()
    {
        $units = $this->paginate($this->Units, [
            'order' => ['Units.name']
        ]);
        $this->set(compact('units'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Units->exists($id)) {
            throw new NotFoundException(__('Invalid unit'));
        }

        if ($id == null) {
            $unit = $this->Units->newEntity();
        } else {
            $unit = $this->Units->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $unit = $this->Units->patchEntity($unit, $this->request->getData());
            if ($this->Units->save($unit)) {
                $this->Flash->success(__('The unit has been saved.'), 
                ['params' => ['event' => 'saved.unit']]);

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error(__('The unit could not be saved. Please, try again.'));
        }
        $this->set(compact('unit'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $unit = $this->Units->get($id);
        if ($this->Units->delete($unit)) {
            $this->Flash->success(__('The unit has been deleted.'));
        } else {
            $this->Flash->error(__('The unit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
