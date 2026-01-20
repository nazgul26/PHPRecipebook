<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

class PreparationMethodsController extends AppController
{
    // Authentication required for all actions (default behavior in CakePHP 5)

    public function index()
    {
        $query = $this->PreparationMethods->find()
            ->orderBy(['PreparationMethods.name' => 'ASC']);
        $preparationMethods = $this->paginate($query);
        $this->set(compact('preparationMethods'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->PreparationMethods->exists($id)) {
            throw new NotFoundException(__('Invalid base type'));
        }

        if ($id == null) {
            $preparationMethod = $this->PreparationMethods->newEmptyEntity();
        } else {
            $preparationMethod = $this->PreparationMethods->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $preparationMethod = $this->PreparationMethods->patchEntity($preparationMethod, $this->request->getData());
            if ($this->PreparationMethods->save($preparationMethod)) {
                $this->Flash->success(__('The preparation method has been saved.'),
                ['params' => ['event' => 'saved.preparationMethod']]);

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error(__('The preparation method could not be saved. Please, try again.'));
        }
        $this->set(compact('preparationMethod'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $preparationMethod = $this->PreparationMethods->get($id);
        if ($this->PreparationMethods->delete($preparationMethod)) {
            $this->Flash->success(__('The preparation method has been deleted.'));
        } else {
            $this->Flash->error(__('The preparation method could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
