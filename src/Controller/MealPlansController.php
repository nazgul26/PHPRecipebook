<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class MealPlansController extends AppController
{
    // Filter to hide ingredients of other users
    public $filterConditions = [];
    const LAST_VIEWED_WEEK = "LastViewedWeek";

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Authentication required for all actions (default behavior)

        $this->filterConditions = array('MealPlans.user_id' => $this->Authentication->getIdentity()?->get('id'));
    }

    public function isAuthorized($user): bool
    {
        // The owner of a meal can edit and delete it
        $action = $this->request->getParam('action');
        $passParam = $this->request->getParam('pass');
        if (isset($passParam[0]) && $passParam[0] != "undefined"
                && in_array($action, array('edit', 'delete'))) {
            $mealId = (int) $passParam[0];
            // Little extra access level needed for this. Editors should not mess with meal plans.
            if ($this->isAdmin || $this->MealPlans->isOwnedBy($mealId, $user['id'])) {
                return true;
            } else {
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
        $startDayOfWeek = $this->Authentication->getIdentity()?->get('meal_plan_start_day');
        $this->MealPlans->InitDate($date, $startDayOfWeek);
        $weekList = $this->MealPlans->getWeekDaysList();
        $currentMonth = $this->MealPlans->currentMonth;
        $startDate = $this->MealPlans->MonthsAbbreviated[$weekList[0][1] - 1] . " " . $weekList[0][0] . ", " . $weekList[0][2];
        $endDate = $this->MealPlans->MonthsAbbreviated[$weekList[6][1] - 1] . " " . $weekList[6][0] . ", " . $weekList[6][2];
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
            'startDayOfWeek'
        ));
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
        $mealPlan = $this->MealPlans->get($id, contain: ['MealNames', 'Recipes', 'Users']);

        $this->set('mealPlan', $mealPlan);
    }

    public function edit($id = null, $mealDate = null)
    {
        if ($id == "undefined") $id = null;

        if ($id != null && !$this->MealPlans->exists($id)) {
            throw new NotFoundException(__('Invalid meal plan'));
        }

        if ($id == null) {
            $mealPlan = $this->MealPlans->newEmptyEntity();
            $mealPlan->mealday = $mealDate;
        } else {
            $mealPlan = $this->MealPlans->get($id, contain: ['Recipes']);
        }

        if ($this->request->is(array('post', 'put'))) {
            $requestData = $this->request->getData();
            $allSuccessful = true; // good, until it is bad.
            $requestData['user_id'] = $this->Authentication->getIdentity()?->get('id');
            $mealPlan = $this->MealPlans->patchEntity($mealPlan, $requestData);

            // Save first copy
            if (!$this->MealPlans->save($mealPlan)) {
                $allSuccessful = false;
            }

            // Any additional 'repeat' days. Aka Leftovers
            list($year, $month, $day) = explode("-", $mealDate);

            $requestData['id'] = "";
            for ($repeatForDays = ($requestData['days'] - 1); $repeatForDays > 0; $repeatForDays--) {
                list($day, $month, $year) = $this->MealPlans->getNextDay($day, $month, $year);

                if (isset($requestData['skip']) && $requestData['skip'] == "1") {
                    list($day, $month, $year) = $this->MealPlans->getNextDay($day, $month, $year);
                }

                $mealPlan = $this->MealPlans->newEmptyEntity();
                $requestData['mealday'] = $year . "-" . $month . "-" . $day;
                $mealPlan = $this->MealPlans->patchEntity($mealPlan, $requestData);

                if (!$this->MealPlans->save($mealPlan)) {
                    $allSuccessful = false;
                }
            }

            if ($allSuccessful) {
                $this->Flash->success(__('The meal plan has been saved.'), ['params' => ['event' => 'saved.meal']]);
            } else {
                $this->Flash->error(__('The meal plan could not be saved. Please, try again.'));
            }
        }
        $mealNames = $this->MealPlans->MealNames->find('list', limit: 200);
        $this->set(compact('mealNames', 'mealPlan', 'mealDate'));
    }

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

    public function addToShoppingList($date)
    {
        if ($date == null) {
            throw new BadRequestException(__('Start date not defined'));
        }
        $shoppingTable = $this->fetchTable('ShoppingLists');
        $this->MealPlans->InitDate($date, $this->Authentication->getIdentity()?->get('meal_plan_start_day'));
        $weekList = $this->MealPlans->getWeekDaysList();
        $meals = $this->getMeals($weekList);

        $userId = $this->Authentication->getIdentity()?->get('id');
        $list = $shoppingTable->getList($userId);
        $listId = $list->id;
        $listItems = [];
        foreach ($meals as $item) {
            $recipeId = $item->recipe_id;
            $servings = $item->servings;
            if (isset($listItems[$recipeId])) {
                $listItems[$recipeId]['servings'] += $servings;
            } else {
                $listItems[$recipeId] = ['servings' => $servings, 'id' => $recipeId];
            }
        }

        foreach ($listItems as $item) {
            $listItem = $shoppingTable->ShoppingListRecipes->newEmptyEntity();
            $listItem->shopping_list_id = $listId;
            $listItem->recipe_id = $item['id'];
            $listItem->servings = $item['servings'];
            $listItem->user_id = $userId;

            //Patch vs Add
            //$item = $this->ShoppingListRecipes->patchEntity($item, $newData);
            $saveOk = $shoppingTable->ShoppingListRecipes->save($listItem);

            /*$this->ShoppingLists->ShoppingListRecipes->addToShoppingList(
                    $listId,
                    $item['id'],
                    $item['servings'],
                    $userId)*/

            if ($saveOk) {
                $this->Flash->success(__('Meal(s) added to shopping list.'));
            } else {
                $this->Flash->error(__('Meal(s) could not be added to shopping list. Please, try again.'));
            }
        }
        return $this->redirect(array('controller' => 'shoppingLists', 'action' => 'index'));
    }


    private function getMeals($weekList)
    {
        $start = $weekList[0][2] . "-" . $weekList[0][1] . "-" . $weekList[0][0];
        $end = $weekList[6][2] . "-" . $weekList[6][1] . "-" . $weekList[6][0];
        return $this->MealPlans->find()
            ->contain([
                'MealNames' => [
                    'fields' => ['id', 'name']
                ],
                'Recipes' => [
                    'fields' => ['name']
                ]
            ])
            //'conditions' => array_merge($this->filterConditions, ['MealPlans.mealday BETWEEN ? AND ?' => [$start,$end]])
            ->where(array_merge(
                $this->filterConditions,
                ['MealPlans.mealday >=' => $start,
                 'MealPlans.mealday <=' => $end]
            ));
    }
}
