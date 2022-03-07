<?php
namespace App\Controller;

use App\Controller\AppController;

class MealPlansController extends AppController
{
    // Filter to hide ingredients of other users
    public $filterConditions = [];
    const LAST_VIEWED_WEEK = "LastViewedWeek"; 
    
    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->deny(); // Deny ALL, user must be logged in.
        
        $this->filterConditions = array('MealPlans.user_id' => $this->Auth->user('id'));
    }
    
    public function isAuthorized($user) {
        // The owner of a meal can edit and delete it
        $action = $this->request->getParam('action');
        $passParam = $this->request->getParam('pass');
        if (isset($passParam[0]) && $passParam[0] != "undefined" 
                && in_array($action, array('edit', 'delete'))) {
            $mealId = (int) $passParam[0];
            // Little extra access level needed for this. Editors should not mess with meal plans.
            if ($this->isAdmin|| $this->MealPlans->isOwnedBy($mealId, $user['id'])) {
                return true;
            }
            else {
                $this->Flash->error(__("Not meal owner"));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }
        
    public function index($date = null)
    {
        $session = $this->getRequest()->getSession();
        $weekDays = $this->MealPlans->DaysFull;
        if ($date == null && $session->read(self::LAST_VIEWED_WEEK) != null) {
            $date = $session->read(self::LAST_VIEWED_WEEK);
        } else if ($date == null) {
            $date = date('m-d-Y');
        } else if ($date != null) {
            $session->write(self::LAST_VIEWED_WEEK, $date);
        }
        $startDayOfWeek = $this->Auth->user('meal_plan_start_day');
        $this->MealPlans->InitDate($date, $startDayOfWeek);
        $weekList = $this->MealPlans->getWeekDaysList();
        $currentMonth = $this->MealPlans->currentMonth;
        $startDate = $this->MealPlans->MonthsAbbreviated[$weekList[0][1]-1] . " " . $weekList[0][0] . ", " . $weekList[0][2];
        $endDate = $this->MealPlans->MonthsAbbreviated[$weekList[6][1]-1] . " " . $weekList[6][0] . ", " . $weekList[6][2];
        $nextWeek = $this->MealPlans->getNextWeek();
	    $previousWeek = $this->MealPlans->getPreviousWeek();
        $realDay = $this->MealPlans->realDay;
        $realMonth = $this->MealPlans->realMonth;
        $realYear = $this->MealPlans->realYear;
        
        $meals = $this->getMeals($weekList);
        $mealList = [];
        foreach ($meals as $meal) {
            $mealDay = $meal->mealday->format('Y-m-d');
            $mealList[$mealDay][] = $meal;
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
     * View method
     *
     * @param string|null $id Meal Plan id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mealPlan = $this->MealPlans->get($id, [
            'contain' => ['MealNames', 'Recipes', 'Users'],
        ]);

        $this->set('mealPlan', $mealPlan);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mealPlan = $this->MealPlans->newEntity();
        if ($this->request->is('post')) {
            $mealPlan = $this->MealPlans->patchEntity($mealPlan, $this->request->getData());
            if ($this->MealPlans->save($mealPlan)) {
                $this->Flash->success(__('The meal plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meal plan could not be saved. Please, try again.'));
        }
        $mealNames = $this->MealPlans->MealNames->find('list', ['limit' => 200]);
        $recipes = $this->MealPlans->Recipes->find('list', ['limit' => 200]);
        $users = $this->MealPlans->Users->find('list', ['limit' => 200]);
        $this->set(compact('mealPlan', 'mealNames', 'recipes', 'users'));
    }

    public function edit($id = null, $mealDate=null) {
        if ($id == "undefined") $id = null;
        
        if ($id != null && !$this->MealPlans->exists($id)) {
                throw new NotFoundException(__('Invalid meal plan'));
        }

        if ($id == null) {
            $mealPlan = $this->MealPlans->newEntity();
            $mealPlan->mealday = $mealDate;
        } else {
            $mealPlan = $this->MealPlans->get($id, ['contain' => ['Recipes']]);
        }

        if ($this->request->is(array('post', 'put'))) {
            $requestData = $this->request->getData();
            $allSuccessful = true; // good, until it is bad.
            $requestData['user_id'] = $this->Auth->user('id');
            $mealPlan = $this->MealPlans->patchEntity($mealPlan, $requestData);
            
            // Save first copy
            if (!$this->MealPlans->save($mealPlan)) {
                    $allSuccessful = false;
            }
            
            // Any additional 'repeat' days. Aka Leftovers
            list($year, $month, $day) = explode("-",$mealDate);
            print_r($requestData);
            $requestData['id'] = "";
            for ($repeatForDays = ($requestData['days'] - 1); $repeatForDays > 0; $repeatForDays--) {
                echo "Days : " . $repeatForDays . "<br>";
                list($day, $month, $year) = $this->MealPlan->getNextDay($day, $month, $year);
                if (isset($this->request->data['skip']) && $this->request->data['skip'] == "1") {
                    list($day, $month, $year) = $this->MealPlans->getNextDay($day, $month, $year);
                }
                
                $mealPlan = $this->MealPlans->newEntity();
                $requestData['mealday'] = $year . "-" . $month . "-" . $day;
                $mealPlan = $this->MealPlans->patchEntity($mealPlan, $requestData);
                
                if (!$this->MealPlan->save($mealPlan)) {
                    $allSuccessful = false;
                }
            }
            
            if ($allSuccessful) {
                $this->Flash->success(__('The meal plan has been saved.'), ['params' => ['event' => 'saved.meal']]);
            } else {
                $this->Flash->error(__('The meal plan could not be saved. Please, try again.'));
            }
        } 
        $mealNames = $this->MealPlans->MealNames->find('list', ['limit' => 200]);
        $this->set(compact('mealNames', 'mealPlan', 'mealDate'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Meal Plan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mealPlan = $this->MealPlans->get($id);
        if ($this->MealPlans->delete($mealPlan)) {
            $this->Flash->success(__('The meal plan has been deleted.'));
        } else {
            $this->Flash->error(__('The meal plan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function getMeals($weekList) {
        $start = $weekList[0][2] . "-" . $weekList[0][1] . "-" . $weekList[0][0];
        $end = $weekList[6][2] . "-" . $weekList[6][1] . "-" . $weekList[6][0];
        return $this->MealPlans->find('all', [
            'contain' => [
                'MealNames' => [
                    'fields' => ['id', 'name']
                ],
                'Recipes' => [
                    'fields' => ['name']
                ]
            ],
            //'conditions' => array_merge($this->filterConditions, ['MealPlans.mealday BETWEEN ? AND ?' => [$start,$end]])
            'conditions' => array_merge($this->filterConditions, 
                ['MealPlans.mealday >=' => $start,
                 'MealPlans.mealday <='=> $end]
            )
        ]);
    }
}
