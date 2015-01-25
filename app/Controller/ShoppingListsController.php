<?php
App::uses('AppController', 'Controller');
/**
 * ShoppingLists Controller
 *
 * @property ShoppingList $ShoppingList
 * @property PaginatorComponent $Paginator
 */
class ShoppingListsController extends AppController {

    public $components = array('Paginator');
    
    // Filter to hide recipes of other users
    public $filterConditions = array();
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.
        
        $this->filterConditions = array('ShoppingList.user_id' => $this->Auth->user('id'));
    }
    
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->ShoppingList->recursive = 0;
        $this->set('shoppingLists', $this->Paginator->paginate('ShoppingList', $this->filterConditions));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->ShoppingList->exists($id)) {
                throw new NotFoundException(__('Invalid shopping list'));
        }
        $options = array('conditions' => array('ShoppingList.' . $this->ShoppingList->primaryKey => $id));
        $this->set('shoppingList', $this->ShoppingList->find('first', $options));
    }
    
    public function select() {
    
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->ShoppingList->exists($id)) {
                throw new NotFoundException(__('Invalid shopping list'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['ShoppingList']['user_id'] = $this->Auth->user('id');
            if ($this->ShoppingList->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The shopping list has been saved.'), 'success');
                return $this->redirect(array('action' => 'edit'));
            } else {
                $this->Session->setFlash(__('The shopping list name could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->ShoppingList->getList($id, $this->Auth->user('id'));
        }
        $units = $this->ShoppingList->ShoppingListIngredient->Ingredient->Unit->find('list');
        $list = $this->request->data;
        $this->set(compact('list', 'units'));
    }

    public function delete($id = null) {
        
        $this->ShoppingList->id = $id;
        if (!$this->ShoppingList->exists()) {
                throw new NotFoundException(__('Invalid shopping list'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->ShoppingList->delete()) {
                $this->Session->setFlash(__('The shopping list has been deleted.'), 'success');
        } else {
                $this->Session->setFlash(__('The shopping list could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function deleteRecipe($listId, $recipeId) {
        
        // TODO logic
    }
    
    public function deleteIngredient($listId, $ingredientId) {
        
        // TODO logic
    }
    
    public function addRecipe($id=null) {
        $this->loadModel('Recipe');
        if ($id == null || !$this->Recipe->exists($id)) {
            throw new NotFoundException(__('Invalid recipe'));
        }
        $userId = $this->Auth->user('id');
        $defaultListId = $this->ShoppingList->getDefaultListId($userId);
        
        $newData = array(
            'id' => NULL,
            'shopping_list_id' => $defaultListId,
            'recipe_id' => $id,
            'scale' => 1,
            'user_id' => $userId
        );

        if ($this->ShoppingList->ShoppingListRecipe->save($newData)) {
            $this->Session->setFlash(__('Recipe added to list.'), 'success');
            
        } else {
            $this->Session->setFlash(__('Unable to add recipe to list.'));
        }
        
        return $this->redirect(array('action' => 'edit'));
    }
    
    public function addIngredient($id=null) {
        $this->loadModel('Ingredient');
        if ($id == null || !$this->Ingredient->exists($id)) {
            throw new NotFoundException(__('Invalid ingredient'));
        }
        $userId = $this->Auth->user('id');
        $defaultListId = $this->ShoppingList->getDefaultListId($userId);
        
        $newData = array(
            'id' => NULL,
            'shopping_list_id' => $defaultListId,
            'ingredient_id' => $id,
            'quantity' => 1,
            'unit_id' => 1,
            'user_id' => $userId
        );

        if ($this->ShoppingList->ShoppingListIngredient->save($newData)) {
            $this->Session->setFlash(__('Ingredient added to list.'), 'success');
            
        } else {
            $this->Session->setFlash(__('Unable to add ingredient to list.'));
        }
        
        return $this->redirect(array('action' => 'edit'));
    }
 }
