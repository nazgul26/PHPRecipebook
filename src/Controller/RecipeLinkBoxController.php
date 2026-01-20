<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class RecipeLinkBoxController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index']);
    }

    public function index()
    {
        $recipesTable = $this->fetchTable('Recipes');
        //TODO: make this a setting to filter out mine (probably remember last login to get ID)
        //$userFilter = array('Recipe.user_id' => $this->Authentication->getIdentity()?->get('id'));
        $userFilter = array();

        $this->viewBuilder()->setLayout('ajax');
        $baseTypesList = $this->fetchTable('BaseTypes')->find('list')->orderBy(['name' => 'ASC']);
        $baseTypes = [];
        foreach ($baseTypesList as $baseId => $baseValue) {
            $count = $recipesTable->find()->where(array_merge($userFilter, ['Recipes.base_type_id' => $baseId]))->count();
            $baseTypes[$baseValue]["count"] = $count;
            $baseTypes[$baseValue]["id"] = $baseId;
        }
        $this->set('baseTypes', $baseTypes);

        $coursesList = $this->fetchTable('Courses')->find('list')->orderBy(['name' => 'ASC']);
        $courses = [];
        foreach ($coursesList as $courseId => $courseValue) {
            $count = $recipesTable->find()->where(array_merge($userFilter, ['Recipes.course_id' => $courseId]))->count();
            $courses[$courseValue]["count"] = $count;
            $courses[$courseValue]["id"] = $courseId;
        }
        $this->set('courses', $courses);

        $prepMethodsList = $this->fetchTable('PreparationMethods')->find('list')->orderBy(['name' => 'ASC']);
        $prepMethods = [];
        foreach ($prepMethodsList as $prepId => $prepValue) {
            $count = $recipesTable->find()->where(array_merge($userFilter, ['Recipes.preparation_method_id' => $prepId]))->count();
            $prepMethods[$prepValue]["count"] = $count;
            $prepMethods[$prepValue]["id"] = $prepId;
        }
        $this->set('prepMethods', $prepMethods);
    }
}
