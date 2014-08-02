<?php
App::uses('AppController', 'Controller');
/**
 * MealPlans Controller
 *
 * @property MealPlan $MealPlan
 * @property PaginatorComponent $Paginator
 */
class MealPlansController extends AppController {

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
        $this->MealPlan->recursive = 0;
        $this->set('mealPlans', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
            if (!$this->MealPlan->exists($id)) {
                    throw new NotFoundException(__('Invalid meal plan'));
            }
            $options = array('conditions' => array('MealPlan.' . $this->MealPlan->primaryKey => $id));
            $this->set('mealPlan', $this->MealPlan->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
            if ($this->request->is('post')) {
                    $this->MealPlan->create();
                    if ($this->MealPlan->save($this->request->data)) {
                            $this->Session->setFlash(__('The meal plan has been saved.'));
                            return $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The meal plan could not be saved. Please, try again.'));
                    }
            }
            $mealNames = $this->MealPlan->MealName->find('list');
            $recipes = $this->MealPlan->Recipe->find('list');
            $users = $this->MealPlan->User->find('list');
            $this->set(compact('mealNames', 'recipes', 'users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
            if (!$this->MealPlan->exists($id)) {
                    throw new NotFoundException(__('Invalid meal plan'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    if ($this->MealPlan->save($this->request->data)) {
                            $this->Session->setFlash(__('The meal plan has been saved.'));
                            return $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The meal plan could not be saved. Please, try again.'));
                    }
            } else {
                    $options = array('conditions' => array('MealPlan.' . $this->MealPlan->primaryKey => $id));
                    $this->request->data = $this->MealPlan->find('first', $options);
            }
            $mealNames = $this->MealPlan->MealName->find('list');
            $recipes = $this->MealPlan->Recipe->find('list');
            $users = $this->MealPlan->User->find('list');
            $this->set(compact('mealNames', 'recipes', 'users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
            $this->MealPlan->id = $id;
            if (!$this->MealPlan->exists()) {
                    throw new NotFoundException(__('Invalid meal plan'));
            }
            $this->request->onlyAllow('post', 'delete');
            if ($this->MealPlan->delete()) {
                    $this->Session->setFlash(__('The meal plan has been deleted.'));
            } else {
                    $this->Session->setFlash(__('The meal plan could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'index'));
    }

}
