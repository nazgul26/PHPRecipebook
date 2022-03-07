<?php
namespace App\Controller;

use App\Controller\AppController;


class ShoppingListsController extends AppController
{
    const SHOPPING_LIST = "ShoppingList"; // Session VAR
    public $helpers = ['Fraction'];
    
    // Filter to hide recipes of other users
    public $filterConditions = [];
    
    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->deny(); // Deny ALL, user must be logged in.
        
        $this->filterConditions = ['ShoppingLists.user_id' => $this->Auth->user('id')];
    }
    
    public function isAuthorized($user) {
        // The owner of a list can edit and delete it. Check every operation
        $passParam = $this->request->getParam('pass');
        if (isset($passParam[0])) {
            $listId = (int)$passParam[0];
            if ($this->Users->isEditor($user) || $this->ShoppingLists->isOwnedBy($listId, $user['id'])) {
                return true;
            } else {
                $this->Flash->error(__('Not List Owner or Editor'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function index($id = null) {
        $this->loadModel('Units');

        if ($id != null && !$this->ShoppingLists->exists($id)) {
                throw new NotFoundException(__('Invalid shopping list'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->getData();
            $listId = $data["id"];
            $list = $this->ShoppingLists->get($listId, ['contain' => [
                'ShoppingListRecipes',
                'ShoppingListIngredients'
            ]]);
            $list = $this->ShoppingLists->patchEntity($list, $data);
            $list->user_id = $this->Auth->user('id');
            if ($this->ShoppingLists->save($list)) {
                $this->Flash->success(__('The shopping has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash(__('The shopping list name could not be saved. Please, try again.'));
            }
        } else {
            $userId = $this->Auth->user('id');
            $shoppingList = $this->ShoppingLists->getList($userId, $id);
        }
        $units = $this->Units->find('list');
        $this->set(compact('units', 'shoppingList'));
    }
 
    public function deleteRecipe($listId, $recipeId) {
        $this->ShoppingLists->ShoppingListRecipes->recursive = 0;
        $item = $this->ShoppingLists->ShoppingListRecipes->getIdToDelete($listId, $recipeId, $this->Auth->user('id')); 
        if (isset($item)) {
            if ($this->ShoppingLists->ShoppingListRecipes->delete($item)) {
                $this->Flash->success(__('The item has been saved.'));
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        } else {
            throw new NotFoundException(__('Invalid recipe item'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function deleteIngredient($listId, $itemId) {
        $this->ShoppingLists->ShoppingListIngredients->recursive = 0;
        $item = $this->ShoppingLists->ShoppingListIngredients->getIdToDelete($listId, $itemId, $this->Auth->user('id')); 
        if (isset($item)) {
            if ($this->ShoppingLists->ShoppingListIngredients->delete($item)) {
                $this->Flash->success(__('The item has been saved.'));
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        } else {
            throw new NotFoundException(__('Invalid ingredient item'));
        }
        return $this->redirect(array('action' => 'index', $listId));
    }
    
    public function addRecipe($listId=null, $recipeId=null, $servings=1) {
        $this->loadModel('Recipes');
        if ($listId == null || $recipeId == null || !$this->Recipes->exists($recipeId)) {
            throw new NotFoundException(__('Invalid recipe'));
        }
        
        $userId = $this->Auth->user('id');
        
        // Create the list if needed
        if ($listId == 0) {
            $listId = $this->ShoppingLists->getDefaultListId($userId);
        }
        //TODO: 
        //  * Update Existing Recipe (update Quantity) if already in list
        //  * Add Linked recipes
        //$saveResult = $this->ShoppingLists->ShoppingListRecipes->addToShoppingList($listId, $recipeId, $servings, $userId);

        $item = $this->ShoppingLists->ShoppingListRecipes->newEntity();
        $item->shopping_list_id = $listId;
        $item->recipe_id = $recipeId;
        $item->servings = $servings;
        $item->user_id = $userId;

        //$item = $this->ShoppingListRecipes->patchEntity($item, $newData);
        $saveOk = $this->ShoppingLists->ShoppingListRecipes->save($item);

        if ($saveOk) {
            $this->Flash->success(__('Recipe added to list.'));
        } else {
            $this->Flash->error(__('Unable to add recipe to list.'));
        }
        
        return $this->redirect(array('action' => 'index', $listId));
    }
    
    public function addIngredient($listId=null, $ingredientId=null) {
        $this->loadModel('Ingredients');

        if ($ingredientId == null || $listId == null || !$this->Ingredients->exists($ingredientId)) {
            throw new NotFoundException(__('Invalid ingredient'));
        }

        $item = $this->ShoppingLists->ShoppingListIngredients->newEntity();
        $item->shopping_list_id = $listId;
        $item->ingredient_id = $ingredientId;
        $item->quantity = 1;
        $item->unit_id = 1;
        $item->user_id = $this->Auth->user('id');
  
        if ($this->ShoppingLists->ShoppingListIngredients->save($item)) {
            $this->Flash->success(__('Ingredient added to list.'));
            
        } else {
            $this->Flash->error(__('Unable to add ingredient to list.'));
        }
        
        return $this->redirect(array('action' => 'index', $listId));
    }
    
    public function select($listId=null) {
        if ($listId == null) {
            throw new NotFoundException(__('Invalid list'));
        }
        
        $ingredients = $this->loadShoppingList($listId);
        $this->set('list', $ingredients); 
        $this->set('listId', $listId);
    }
    
    public function instore($listId=null) {
        if ($listId == null) {
            throw new NotFoundException(__('Invalid list'));
        }
        
        if ($this->request->is(array('post', 'put'))) { 
            $this->loadModel('Stores');

            $postData = $this->request->getData();

            // Check if we are done and if so clear list and redirect.
            if (isset($this->request->data['done']) && $this->request->data['done'] == "1") {
                $this->ShoppingLists->clearList($this->Auth->user('id'));
                $this->Flash->success(__('Shopping done! List cleared.'));
                return $this->redirect(array('action' => 'index', $listId));
            }
            
            // Remove items picked during select step
            $removeIds = [];
            if (isset($postData['remove'])) {
                $removeIds = $postData['remove'];
                $this->set('removeIds', $removeIds);
            }
            
            // Figure out what store layout to use
            $stores = $this->Stores->find('list');
            $selectedStoreId = null;
            if (isset($this->request->data['ShoppingList']['store_id'])) {
                $selectedStoreId = $this->request->data['ShoppingList']['store_id'];
            } else if (isset($stores) && $stores->count() > 0) {
                $selectedStoreId = array_key_first($stores->toArray());
            }
            $store = $this->Stores->get($selectedStoreId);

            // Load and remove extra items
            $ingredients = $this->removeSelectedItems($listId, $removeIds);

            // Sort by the currently selected store
            $locationIds = explode(",", $store->layout);
            $ingredients = $this->Locations->orderShoppingListByStore($ingredients, $locationIds);
            
            $this->set('list', $ingredients);
            $this->set('listId', $listId);
            $this->set('stores', $stores);
        } else {
            // Missing post data, really can't continue, send them back.
            return $this->redirect(array('action' => 'index', $listId));
        }
    }
    
    public function online($listId=null) {
        if ($listId == null) {
            throw new NotFoundException(__('Invalid list'));
        }
        
        $this->loadModel('Vendors');
        $this->loadModel('VendorProducts');
        
        if ($this->request->is(array('post', 'put'))) { 
            $postData = $this->request->getData();
            $removeIds = isset($postData['remove']) ? $postData['remove'] : NULL;
            $ingredients = $this->removeSelectedItems($listId, $removeIds);
            $this->set('list', $ingredients);
            $this->set('listId', $listId);
        }
        
        $vendors = $this->Vendors->find('list');
        
        // Load the first Vendor as the Selected one and filter to User setup mappings
        if (isset($vendors)) {
            $selectedVendorId = array_key_first($vendors->toArray());
            $selectedVendor = $this->Vendors->find('all', 
                ['conditions' => ['Vendors.id' => $selectedVendorId],
                      'contain' => array(
                            'VendorProducts' => array(
                                'conditions' => array('VendorProducts.user_id =' => $this->Auth->user('id'))
                            )
                        )
                ])->first();
 
            $this->request->data = $selectedVendor;
            $this->set('selectedVendor', $selectedVendor);
        }
              
	    $this->set('vendors', $vendors);
    }
    
    public function clear() {
        $this->ShoppingLists->clearList($this->Auth->user('id'));
        $this->Flash->success(__('Shopping done! List cleared.'));
        return $this->redirect(array('action' => 'index'));
    }
    
    private function loadShoppingList($listId) {
        $this->loadModel('Recipes');
        $this->loadModel('Locations');

        $ingredientQuery = $this->ShoppingLists->getAllIngredients($listId, $this->Auth->user('id'));
        $ingredients = $this->ShoppingLists->combineIngredients($ingredientQuery);
        $ingredients = $this->Locations->orderShoppingListByLocation($ingredients);
        return $ingredients;
    }
    
    private function removeSelectedItems($listId, $removeIds) {
        $ingredients = $this->loadShoppingList($listId);
        if (isset($removeIds)) {
            $ingredients = $this->ShoppingLists->markIngredientsRemoved($ingredients, $removeIds);
        }
        return $ingredients;
    }
}
