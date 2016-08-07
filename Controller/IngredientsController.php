<?php

App::uses('AppController', 'Controller');
/**
 * Ingredients Controller.
 *
 * @property Ingredient $Ingredient
 * @property PaginatorComponent $Paginator
 */
class IngredientsController extends AppController
{
    public $components = ['Paginator', 'RequestHandler'];

    public $paginate = [
        'order' => [
            'Ingredient.name' => 'asc',
        ],
    ];

    // Filter to hide ingredients of other users
    public $filterConditions = [];

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.

        $this->filterConditions = ['Ingredient.user_id' => $this->Auth->user('id')];
    }

    public function isAuthorized($user)
    {
        // The owner of a ingredient can edit and delete it
        if (in_array($this->action, ['edit', 'delete']) && isset($this->request->params['pass'][0])) {
            $ingredientId = (int) $this->request->params['pass'][0];

            if ($this->User->isEditor($user) || $this->Ingredient->isOwnedBy($ingredientId, $user['id'])) {
                return true;
            } else {
                $this->Session->setFlash(__('Not Ingredient Owner'));

                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    /**
     * index method.
     *
     * @return void
     */
    public function index()
    {
        $this->Ingredient->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('ingredients', $this->Paginator->paginate('Ingredient', $this->filterConditions));
    }

    /**
     * edit method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function edit($id = null)
    {
        if ($id != null && !$this->Ingredient->exists($id)) {
            throw new NotFoundException(__('Invalid ingredient'));
        }

        if ($this->request->is(['post', 'put'])) {
            //TODO: Keep the original author just in case editor/admin edits
            $this->request->data['Ingredient']['user_id'] = $this->Auth->user('id');
            if ($this->Ingredient->save($this->request->data)) {
                $this->Session->setFlash(__('The ingredient has been saved.'), 'success', ['event' => 'savedIngredient']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The ingredient could not be saved. Please, try again.'));
            }
        } elseif ($id != null) {
            $options = ['conditions' => ['Ingredient.'.$this->Ingredient->primaryKey => $id]];
            $this->request->data = $this->Ingredient->find('first', $options);
        }
        $locations = $this->Ingredient->Location->find('list');
        $units = $this->Ingredient->Unit->find('list');
        $users = $this->Ingredient->User->find('list');
        $this->set(compact('locations', 'units', 'users'));
    }

    public function delete($id = null)
    {
        $this->Ingredient->id = $id;
        if (!$this->Ingredient->exists()) {
            throw new NotFoundException(__('Invalid ingredient'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Ingredient->delete()) {
            $this->Session->setFlash(__('The ingredient has been deleted.'), 'success');
        } else {
            $this->Session->setFlash(__('The ingredient could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $term = $this->request->query('term');
        if ($term) {
            $this->Ingredient->recursive = 0;
            $this->Paginator->settings = $this->paginate;
            $this->set('ingredients', $this->Paginator->paginate('Ingredient',
                    array_merge($this->filterConditions, ['LOWER(Ingredient.name) LIKE' => '%'.trim(strtolower($term)).'%'])));
        } else {
            $this->set('ingredients', $this->Paginator->paginate('Ingredient', $this->filterConditions));
        }
        $this->render('index');
    }

    public function autoCompleteSearch()
    {
        $searchResults = [];
        $term = $this->request->query('term');
        if ($term) {
            $ingredients = $this->Ingredient->find('all', [
              'conditions' => array_merge($this->filterConditions, ['LOWER(Ingredient.name) LIKE ' => '%'.trim(strtolower($term)).'%']),
            ]);

            if (count($ingredients) > 0) {
                foreach ($ingredients as $item) {
                    $key = $item['Ingredient']['name'];
                    $value = $item['Ingredient']['id'];
                    array_push($searchResults, ['id' => $value, 'value' => strip_tags($key)]);
                }
            } else {
                $key = "No Results for '$term' Found";
                array_push($searchResults, ['id' => '', 'value' => $key]);
            }

            $this->set(compact('searchResults'));
            $this->set('_serialize', 'searchResults');
        }
    }
}
