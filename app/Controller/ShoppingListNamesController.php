<?php
App::uses('AppController', 'Controller');
/**
 * ShoppingListNames Controller
 *
 * @property ShoppingListName $ShoppingListName
 * @property PaginatorComponent $Paginator
 */
class ShoppingListNamesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->ShoppingListName->recursive = 0;
        $this->set('shoppingListNames', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->ShoppingListName->exists($id)) {
                throw new NotFoundException(__('Invalid shopping list name'));
        }
        $options = array('conditions' => array('ShoppingListName.' . $this->ShoppingListName->primaryKey => $id));
        $this->set('shoppingListName', $this->ShoppingListName->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
                $this->ShoppingListName->create();
                if ($this->ShoppingListName->save($this->request->data)) {
                        $this->Session->setFlash(__('The shopping list name has been saved.'));
                        return $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The shopping list name could not be saved. Please, try again.'));
                }
        }
        $users = $this->ShoppingListName->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->ShoppingListName->exists($id)) {
                throw new NotFoundException(__('Invalid shopping list name'));
        }
        if ($this->request->is(array('post', 'put'))) {
                if ($this->ShoppingListName->save($this->request->data)) {
                        $this->Session->setFlash(__('The shopping list name has been saved.'));
                        return $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The shopping list name could not be saved. Please, try again.'));
                }
        } else {
                $options = array('conditions' => array('ShoppingListName.' . $this->ShoppingListName->primaryKey => $id));
                $this->request->data = $this->ShoppingListName->find('first', $options);
        }
        $users = $this->ShoppingListName->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->ShoppingListName->id = $id;
        if (!$this->ShoppingListName->exists()) {
                throw new NotFoundException(__('Invalid shopping list name'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->ShoppingListName->delete()) {
                $this->Session->setFlash(__('The shopping list name has been deleted.'));
        } else {
                $this->Session->setFlash(__('The shopping list name could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
 }
