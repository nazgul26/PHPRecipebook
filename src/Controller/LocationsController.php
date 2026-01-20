<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

class LocationsController extends AppController
{
    public $filterConditions = [];

    // Authentication required for all actions (default behavior in CakePHP 5)

    public function index()
    {
        $query = $this->Locations->find()
            ->orderBy(['Locations.name' => 'ASC']);
        $locations = $this->paginate($query);
        $this->set(compact('locations'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Locations->exists($id)) {
            throw new NotFoundException(__('Invalid base type'));
        }

        if ($id == null) {
            $location = $this->Locations->newEmptyEntity();
        } else {
            $location = $this->Locations->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'),
                ['params' => ['event' => 'saved.location']]);

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $this->set(compact('location'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $term = $this->request->getQuery('term');
        if ($term) {
            $conditions = array_merge($this->filterConditions, array('LOWER(Locations.name) LIKE' => '%' . trim(strtolower($term)) . '%'));
        } else {
            $conditions = $this->filterConditions;
        }

        $query = $this->Locations->find()
            ->where($conditions);
        $locations = $this->paginate($query);
        $this->set(compact('locations'));
        $this->render('index');
    }
}
