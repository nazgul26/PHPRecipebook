<?php
App::uses('AppController', 'Controller');
class RecipeLinkBoxController extends AppController {
    
    public $uses = array(
        'BaseType',
        'Course',
        'Recipe',
        'PreparationMethod'
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    public function index() {  
        //TODO: make this a setting to filter out mine (probably remember last login to get ID)
        //$userFilter = array('Recipe.user_id' => $this->Auth->user('id'));
        $userFilter = array();
        
        $this->layout = 'ajax';
        $baseTypesList = $this->BaseType->find('list', array('order' => array('name')));
        foreach ($baseTypesList as $baseId => $baseValue) {
            $count = $this->Recipe->find('count', array('conditions' => array_merge($userFilter, array('Recipe.base_type_id' => $baseId))));
            $baseTypes[$baseValue]["count"] = $count;
            $baseTypes[$baseValue]["id"] = $baseId;
        }
        $this->set('baseTypes', $baseTypes);
        
        $coursesList = $this->Course->find('list', array('order' => array('name')));
        foreach ($coursesList as $courseId => $courseValue) {
            $count = $this->Recipe->find('count', array('conditions' => array_merge($userFilter, array('Recipe.course_id' => $courseId))));
            $courses[$courseValue]["count"] = $count;
            $courses[$courseValue]["id"] = $courseId;
        }
        $this->set('courses', $courses);
        
        $prepMethodsList = $this->PreparationMethod->find('list', array('order' => array('name')));
        foreach ($prepMethodsList as $prepId => $prepValue) {
            $count = $this->Recipe->find('count', array('conditions' => array_merge($userFilter, array('Recipe.preparation_method_id' => $prepId))));
            $prepMethods[$prepValue]["count"] = $count;
            $prepMethods[$prepValue]["id"] = $prepId;
        }
        $this->set('prepMethods', $prepMethods);
    }
}
?>

