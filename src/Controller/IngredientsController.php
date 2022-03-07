<?php
namespace App\Controller;

use App\Controller\AppController;

class IngredientsController extends AppController
{
    public $filterConditions = array();

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->deny(); // Deny ALL, user must be logged in.
        
        $this->filterConditions = array('Ingredients.user_id' => $this->Auth->user('id'));
    }

    public function isAuthorized($user) {
        // The owner of a ingredient can edit and delete it
        $action = $this->request->getParam('action');
        $passParam = $this->request->getParam('pass');
        if (in_array($action, array('edit', 'delete')) && isset($passParam[0])) {
            $ingredientId = (int) $passParam[0];

            if ($this->Users->isEditor($user) || $this->Ingredients->isOwnedBy($ingredientId, $user['id'])) {
                return true;
            }
            else {
                $this->Flash->error(__('Not Ingredient Owner'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->paginate = [
            'conditions' => $this->filterConditions,
            'contain' => ['Locations', 'Units'],
            'order' => ['Ingredients.name']
        ];
        $ingredients = $this->paginate($this->Ingredients);
        $this->set(compact('ingredients'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Ingredients->exists($id)) {
            throw new NotFoundException(__('Invalid ingredient type'));
        }

        if ($id == null) {
            $ingredient = $this->Ingredients->newEntity();
        } else {
            $ingredient = $this->Ingredients->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $ingredient = $this->Ingredients->patchEntity($ingredient, $this->request->getData());
            //TODO: Keep the original author just in case editor/admin edits
            $ingredient->user_id = $this->Auth->user('id');

            if ($this->Ingredients->save($ingredient)) {
                $this->Flash->success(__('The ingredient has been saved.'), 
                ['params' => ['event' => 'saved.ingredient']]);

                return $this->redirect(array('action' => 'edit'));
            }
            $this->Flash->error(__('The ingredient could not be saved. Please, try again.'));
        }
        $locations = $this->Ingredients->Locations->find('list', ['limit' => 200]);
        $units = $this->Ingredients->Units->find('list', ['limit' => 200]);
        $users = $this->Ingredients->Users->find('list', ['limit' => 200]);
        $this->set(compact('ingredient', 'locations', 'units', 'users'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ingredient = $this->Ingredients->get($id);
        if ($this->Ingredients->delete($ingredient)) {
            $this->Flash->success(__('The ingredient has been deleted.'));
        } else {
            $this->Flash->error(__('The ingredient could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search() {
        $term = $this->request->query('term');
        $conditions = [];
        if ($term)
        {
            $conditions = array_merge($this->filterConditions, array('LOWER(Ingredients.name) LIKE' => '%' . trim(strtolower($term)) . '%'));
        } else {
            $conditions = $this->filterConditions;
        }

        $this->paginate = [
            'conditions' => array_merge($conditions),
            'contain' => ['Locations', 'Units'],
        ];

        $ingredients = $this->paginate($this->Ingredients);
        $this->set(compact('ingredients'));
        $this->render('index');
    }
    
    public function autoCompleteSearch() {
        $searchResults = [];
        $conditions = [];
        $this->RequestHandler->renderAs($this, 'json');

        $term = $this->request->query('term');
        if ($term)
        {
            $conditions = array_merge($this->filterConditions, array('LOWER(Ingredients.name) LIKE' => '%' . trim(strtolower($term)) . '%'));
        } else {
            $conditions = $this->filterConditions;
        }

        $ingredients = $this->Ingredients->find('all', ['conditions' => $conditions]);
        
        if ($ingredients->count() > 0) {
            foreach ($ingredients as $item) {
                $key = $item->name;
                $value = $item->id;
                array_push($searchResults, array('id'=>$value, 'value' => strip_tags($key)));
            }
        } else {
            $key = "No Results for '$term' Found";
            array_push($searchResults, array('id'=> '', 'value' => $key));
        }
            
        $this->set(compact('searchResults'));
        $this->set('_serialize', 'searchResults');
    }
}
