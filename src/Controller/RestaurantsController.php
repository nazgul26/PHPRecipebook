<?php
namespace App\Controller;

use App\Controller\AppController;

class RestaurantsController extends AppController
{
    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->allow('index', 'search');
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['PriceRanges', 'Users'],
            'order' => ['Restaurants.name']
        ];
        $restaurants = $this->paginate($this->Restaurants);

        $this->set(compact('restaurants'));
    }

    public function edit($id = null)
    {
        $restaurant = $this->Restaurants->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $restaurant = $this->Restaurants->patchEntity($restaurant, $this->request->getData());
            if ($this->Restaurants->save($restaurant)) {
                $this->Flash->success(__('The restaurant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The restaurant could not be saved. Please, try again.'));
        }
        $priceRanges = $this->Restaurants->PriceRanges->find('list', ['limit' => 200]);
        $users = $this->Restaurants->Users->find('list', ['limit' => 200]);
        $this->set(compact('restaurant', 'priceRanges', 'users'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $restaurant = $this->Restaurants->get($id);
        if ($this->Restaurants->delete($restaurant)) {
            $this->Flash->success(__('The restaurant has been deleted.'));
        } else {
            $this->Flash->error(__('The restaurant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search() {
        $term = $this->request->query('term');
        $conditions = [];
        if ($term)
        {
            $conditions = array_merge($this->filterConditions, array('LOWER(Restaurants.name) LIKE' => '%' . trim(strtolower($term)) . '%'));
        } else {
            $conditions = $this->filterConditions;
        }

        $this->paginate = [
            'conditions' => array_merge($conditions),
            'contain' => ['PriceRanges', 'Users'],
            'order' => ['Restaurants.name']
        ];

        $restaurants = $this->paginate($this->Restaurants);
        $this->set(compact('restaurants'));
        $this->render('index');
    }
}
