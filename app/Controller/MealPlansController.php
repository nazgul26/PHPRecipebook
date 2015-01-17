<?php
App::uses('AppController', 'Controller');
/**
 * MealPlans Controller
 *
 * @property MealPlan $MealPlan
 * @property PaginatorComponent $Paginator
 */
class MealPlansController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }
    
    /**
     * index method
     *
     * @return void
     */
    public function index($date = null) {
        $weekDays = $this->MealPlan->DaysFull;
        $this->MealPlan->InitDate($date);
        $weekList = $this->MealPlan->getWeekDaysList();
        $currentMonth = $this->MealPlan->currentMonth;
        $startDate = $this->MealPlan->MonthsAbbreviated[$weekList[0][1]-1] . " " . $weekList[0][0] . ", " . $weekList[0][2];
        $endDate = $this->MealPlan->MonthsAbbreviated[$weekList[6][1]-1] . " " . $weekList[6][0] . ", " . $weekList[6][2];
        $nextWeek = $this->MealPlan->getNextWeek();
	$previousWeek = $this->MealPlan->getPreviousWeek();
        $realDay = $this->MealPlan->realDay;
        $realMonth = $this->MealPlan->realMonth;
        $realYear = $this->MealPlan->realYear;
        
        $startDateQuery = $weekList[0][2] . "-" . $weekList[0][1] . "-" . $weekList[0][0];
        $endDateQuery = $weekList[6][2] . "-" . $weekList[6][1] . "-" . $weekList[6][0];
        $meals = $this->MealPlan->find('all', array(
              'conditions' => array('MealPlan.mealday BETWEEN ? AND ?' => array($startDateQuery,$endDateQuery))
        ));
        
        foreach ($meals as $item) {
            $mealList[$item["MealPlan"]["mealday"]][] = $item;
        }
        $this->set(compact('mealList', 'weekDays', 'weekList', 'currentMonth', 'startDate', 'endDate', 'nextWeek', 'previousWeek', 'realDay', 'realMonth', 'realYear', 'date'));
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
            if ($this->MealPlan->save($this->request->data)) {
                $this->Session->setFlash(__('The meal plan has been saved.'), "success", array('event' => 'saved.meal'));
                return $this->redirect(array('action' => 'edit'));
            } else {
                $this->Session->setFlash(__('The meal plan could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MealPlan.' . $this->MealPlan->primaryKey => $id));
            $meal = $this->MealPlan->find('first', $options);
            $this->request->data = $meal;
            if (isset($meal["MealPlan"])) {
                $mealDate = $meal["MealPlan"]["mealday"];
            }
        }
        $mealNames = $this->MealPlan->MealName->find('list');
        $recipes = $this->MealPlan->Recipe->find('list');
        $this->set(compact('mealNames', 'recipes', 'mealDate', 'meal'));
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

}
