<?php
App::uses('AppController', 'Controller');
/**
 * ShoppingListNames Controller
 *
 * @property ShoppingListName $ShoppingListName
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
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The shopping list name could not be saved. Please, try again.'));
            }
        } else {
            $this->ShoppingList->Behaviors->load('Containable');
            $options = array('contain' => array(
                    'ShoppingListIngredient.Ingredient.name', 
                    'ShoppingListRecipe.Recipe.name',
                    'ShoppingListRecipe.Recipe.serving_size'));
            
            if ($id == null) {
                $search = array('conditions' => array('ShoppingList.name' => __('DEFAULT')));
            } else {
                $search = array('conditions' => array('ShoppingList.' . $this->ShoppingList->primaryKey => $id));
            }
            
            $this->request->data = $this->ShoppingList->find('first', array_merge($options, $search));
        }
        $units = $this->ShoppingList->ShoppingListIngredient->Ingredient->Unit->find('list');
        $list = $this->request->data;
        $this->set(compact('list', 'units'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
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
 }
