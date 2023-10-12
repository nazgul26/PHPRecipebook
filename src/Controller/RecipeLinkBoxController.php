<?php
namespace App\Controller;

use App\Controller\AppController;


class RecipeLinkBoxController extends AppController {
    
    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->allow('index');
    }

    public function index() {  
        $recipesTable = $this->fetchTable('Recipes');
        //TODO: make this a setting to filter out mine (probably remember last login to get ID)
        //$userFilter = array('Recipe.user_id' => $this->Auth->user('id'));
        $userFilter = array();
        
        $this->layout = 'ajax';
        $baseTypesList = $this->fetchTable('BaseTypes')->find('list', array('order' => array('name')));
        foreach ($baseTypesList as $baseId => $baseValue) {
            $count = $recipesTable->find('all', array('conditions' => array_merge($userFilter, array('Recipes.base_type_id' => $baseId))))->count();
            $baseTypes[$baseValue]["count"] = $count;
            $baseTypes[$baseValue]["id"] = $baseId;
        }
        $this->set('baseTypes', $baseTypes);
        
        $coursesList = $this->fetchTable('Courses')->find('list', array('order' => array('name')));
        foreach ($coursesList as $courseId => $courseValue) {
            $count = $recipesTable->find('all', array('conditions' => array_merge($userFilter, array('Recipes.course_id' => $courseId))))->count();
            $courses[$courseValue]["count"] = $count;
            $courses[$courseValue]["id"] = $courseId;
        }
        $this->set('courses', $courses);
        
        $prepMethodsList = $this->fetchTable('PreparationMethods')->find('list', array('order' => array('name')));
        foreach ($prepMethodsList as $prepId => $prepValue) {
            $count = $recipesTable->find('all', array('conditions' => array_merge($userFilter, array('Recipes.preparation_method_id' => $prepId))))->count();
            $prepMethods[$prepValue]["count"] = $count;
            $prepMethods[$prepValue]["id"] = $prepId;
        }
        $this->set('prepMethods', $prepMethods);
    }
}
?>

