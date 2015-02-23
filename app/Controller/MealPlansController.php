<?php
App::uses('AppController', 'Controller');
/**
 * MealPlans Controller
 *
 * @property MealPlan $MealPlan
 * @property PaginatorComponent $Paginator
 */
class MealPlansController extends AppController {

    // Filter to hide ingredients of other users
    public $filterConditions = array();
    const LAST_VIEWED_WEEK = "LastViewedWeek"; 
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.
        
        $this->filterConditions = array('MealPlan.user_id' => $this->Auth->user('id'));
    }
    
    public function isAuthorized($user) {
        // The owner of a meal can edit and delete it
        if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] != "undefined" 
                && in_array($this->action, array('edit', 'delete'))) {
            $mealId = (int) $this->request->params['pass'][0];
            // Little extra access level needed for this. Editors should not mess with meal plans.
            if ($this->isAdmin|| $this->MealPlan->isOwnedBy($mealId, $user['id'])) {
                return true;
            }
            else {
                $this->Session->setFlash(__("Not meal owner"));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }
    
    /**
     * index method
     *
     * @return void
     */
    public function index($date = null) {
        $weekDays = $this->MealPlan->DaysFull;
        if ($date == null && $this->Session->read(self::LAST_VIEWED_WEEK) != null) {
            $date = $this->Session->read(self::LAST_VIEWED_WEEK);
        } else if ($date == null) {
            $date = date('m-d-Y');
        } else if ($date != null) {
            $this->Session->write(self::LAST_VIEWED_WEEK, $date);
        }
        $startDayOfWeek = $this->Auth->user('meal_plan_start_day');
        $this->MealPlan->InitDate($date, $startDayOfWeek);
        $weekList = $this->MealPlan->getWeekDaysList();
        $currentMonth = $this->MealPlan->currentMonth;
        $startDate = $this->MealPlan->MonthsAbbreviated[$weekList[0][1]-1] . " " . $weekList[0][0] . ", " . $weekList[0][2];
        $endDate = $this->MealPlan->MonthsAbbreviated[$weekList[6][1]-1] . " " . $weekList[6][0] . ", " . $weekList[6][2];
        $nextWeek = $this->MealPlan->getNextWeek();
	$previousWeek = $this->MealPlan->getPreviousWeek();
        $realDay = $this->MealPlan->realDay;
        $realMonth = $this->MealPlan->realMonth;
        $realYear = $this->MealPlan->realYear;
        
        $meals = $this->getMeals($weekList);
        
        foreach ($meals as $item) {
            $mealList[$item["MealPlan"]["mealday"]][] = $item;
        }
        $this->set(compact(
                'mealList', 
                'weekDays', 
                'weekList', 
                'currentMonth', 
                'startDate', 
                'endDate', 
                'nextWeek', 
                'previousWeek', 
                'realDay', 
                'realMonth', 
                'realYear', 
                'date',
                'startDayOfWeek'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null, $mealDate=null) {
        if ($id != null && $id != "undefined" && !$this->MealPlan->exists($id)) {
                throw new NotFoundException(__('Invalid meal plan'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $allSuccessful = true; // good, until it is bad.
            $this->request->data['MealPlan']['user_id'] = $this->Auth->user('id');
            
            // Save first copy
            if (!$this->MealPlan->save($this->request->data)) {
                    $allSuccessful = false;
            }
            
            // Any additional 'repeat' days. Aka Leftovers
            list($year, $month, $day) = explode("-",$mealDate);
            $this->request->data['MealPlan']['id'] = "";
            for ($repeatForDays = ($this->request->data['MealPlan']['days'] - 1); $repeatForDays > 0; $repeatForDays--) {
                list($day, $month, $year) = $this->MealPlan->getNextDay($day, $month, $year);
                if (isset($this->request->data['MealPlan']['skip']) && $this->request->data['MealPlan']['skip'] == "1") {
                    list($day, $month, $year) = $this->MealPlan->getNextDay($day, $month, $year);
                }
                
                $this->request->data['MealPlan']['mealday'] = $year . "-" . $month . "-" . $day;
                if (!$this->MealPlan->save($this->request->data)) {
                    $allSuccessful = false;
                }
            }
            
            if ($allSuccessful) {
                $this->Session->setFlash(__('The meal plan has been saved.'), "success", array('event' => 'saved.meal'));
                return $this->redirect(array('action' => 'edit'));
            } else {
                $this->Session->setFlash(__('The meal plan could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MealPlan.' . $this->MealPlan->primaryKey => $id));
            $meal = $this->MealPlan->find('first', $options);
            
            if (isset($meal["MealPlan"])) {
                $this->request->data = $meal;
                $mealDate = $meal["MealPlan"]["mealday"];
            }
        }
        $mealNames = $this->MealPlan->MealName->find('list');
        $this->set(compact('mealNames', 'mealDate'));
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
            $this->Session->setFlash(__('The meal plan has been deleted.'), "success");
        } else {
            $this->Session->setFlash(__('The meal plan could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function addToShoppingList($date) {
        if ($date == null) {
            throw new BadRequestException(__('Start date not defined'));
        }   
        $this->loadModel('ShoppingList');
        $this->MealPlan->InitDate($date, $this->Auth->user('meal_plan_start_day'));
        $weekList = $this->MealPlan->getWeekDaysList();
        $meals = $this->getMeals($weekList);
        
        $userId = $this->Auth->user('id');
        $listId = $this->ShoppingList->getDefaultListId($userId);
        
        $listItems = array();
        foreach ($meals as $item) {
            $recipeId = $item['MealPlan']['recipe_id'];
            $servings = $item['MealPlan']['servings'];
            if (isset($listItems[$recipeId])) {
                $listItems[$recipeId]['servings'] += $servings;
            } else {
                $listItems[$recipeId] = array( 'servings' => $servings, 'id' => $recipeId);
            }
        }
        
        foreach ($listItems as $item) {
            $this->ShoppingList->ShoppingListRecipe->addToShoppingList(
                    $listId, 
                    $item['id'], 
                    $item['servings'], 
                    $userId);
        }
        return $this->redirect(array('controller' => 'shoppingLists', 'action' => 'index'));
    }
    
    private function getMeals($weekList) {
        $start = $weekList[0][2] . "-" . $weekList[0][1] . "-" . $weekList[0][0];
        $end = $weekList[6][2] . "-" . $weekList[6][1] . "-" . $weekList[6][0];
        $this->MealPlan->Behaviors->load('Containable');
        return $this->MealPlan->find('all', array(
            'contain' => array(
                'MealName' => array(
                    'fields' => array('id', 'name')
                ),
                'Recipe' => array(
                    'fields' => array('name')
                )
            ),
            'conditions' => array_merge($this->filterConditions, array('MealPlan.mealday BETWEEN ? AND ?' => array($start,$end)))
        ));
    }
}
