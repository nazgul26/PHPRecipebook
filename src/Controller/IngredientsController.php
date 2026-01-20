<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\View\JsonView;

class IngredientsController extends AppController
{
    public $filterConditions = array();

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Authentication required for all actions (default behavior)

        $this->filterConditions = array('Ingredients.user_id' => $this->Authentication->getIdentity()?->get('id'));
    }

    public function isAuthorized($user): bool
    {
        // The owner of a ingredient can edit and delete it
        $action = $this->request->getParam('action');
        $passParam = $this->request->getParam('pass');
        if (in_array($action, array('edit', 'delete')) && isset($passParam[0])) {
            $ingredientId = (int) $passParam[0];
            $usersTable = $this->fetchTable('Users');
            if ($usersTable->isEditor($user) || $this->Ingredients->isOwnedBy($ingredientId, $user['id'])) {
                return true;
            } else {
                $this->Flash->error(__('Not Ingredient Owner'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $query = $this->Ingredients->find()
            ->contain(['Locations', 'Units'])
            ->where($this->filterConditions)
            ->orderBy(['Ingredients.name' => 'ASC']);
        $ingredients = $this->paginate($query);
        $this->set(compact('ingredients'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Ingredients->exists($id)) {
            throw new NotFoundException(__('Invalid ingredient type'));
        }

        if ($id == null) {
            $ingredient = $this->Ingredients->newEmptyEntity();
        } else {
            $ingredient = $this->Ingredients->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $ingredient = $this->Ingredients->patchEntity($ingredient, $this->request->getData());
            //TODO: Keep the original author just in case editor/admin edits
            $ingredient->user_id = $this->Authentication->getIdentity()?->get('id');

            if ($this->Ingredients->save($ingredient)) {
                $this->Flash->success(__('The ingredient has been saved.'),
                ['params' => ['event' => 'saved.ingredient']]);

                return $this->redirect(array('action' => 'edit'));
            }
            $this->Flash->error(__('The ingredient could not be saved. Please, try again.'));
        }
        $locations = $this->Ingredients->Locations->find('list', limit: 200);
        $units = $this->Ingredients->Units->find('list', limit: 200);
        $users = $this->Ingredients->Users->find('list', limit: 200);
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

    public function search()
    {
        $term = $this->request->getQuery('term');
        $conditions = [];
        if ($term) {
            $conditions = array_merge($this->filterConditions, array('LOWER(Ingredients.name) LIKE' => '%' . trim(strtolower($term)) . '%'));
        } else {
            $conditions = $this->filterConditions;
        }

        $query = $this->Ingredients->find()
            ->contain(['Locations', 'Units'])
            ->where($conditions);
        $ingredients = $this->paginate($query);
        $this->set(compact('ingredients'));
        $this->render('index');
    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function autoCompleteSearch()
    {
        $this->request = $this->request->withHeader('Accept', 'application/json');

        $searchResults = [];
        $conditions = [];

        $term = $this->request->getQuery('term');
        if ($term) {
            $conditions = array_merge($this->filterConditions, array('LOWER(Ingredients.name) LIKE' => '%' . trim(strtolower($term)) . '%'));
        } else {
            $conditions = $this->filterConditions;
        }

        $ingredients = $this->Ingredients->find()->where($conditions);

        if ($ingredients->count() > 0) {
            foreach ($ingredients as $item) {
                $key = $item->name;
                $value = $item->id;
                array_push($searchResults, array('id' => $value, 'value' => strip_tags($key)));
            }
        } else {
            $key = "No Results for '$term' Found";
            array_push($searchResults, array('id' => '', 'value' => $key));
        }

        $this->set(compact('searchResults'));
        $this->viewBuilder()->setOption('serialize', 'searchResults');
    }
}
