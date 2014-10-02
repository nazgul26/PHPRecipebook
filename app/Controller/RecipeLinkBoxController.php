<?php
App::uses('AppController', 'Controller');
class RecipeLinkBoxController extends AppController {
    public $uses = array(
        'BaseType',
        'Course',
        'Recipe',
        'PreparationMethod'
    );
    public function index() {  
        $this->layout = 'ajax';
        $baseTypes = $this->BaseType->find('all');
        for ($i=0; $i < count($baseTypes); $i++) {
            
            $count = $this->Recipe->find('count', array('conditions' => array('Recipe.base_type_id' => $baseTypes[$i]["BaseType"]["id"])));
            $baseTypes[$i]["BaseType"]["count"] = $count;
        }
        $this->set('baseTypes', $baseTypes);
        
        $courses = $this->Course->find('all');
        for ($i=0; $i < count($courses); $i++) {
            
            $count = $this->Recipe->find('count', array('conditions' => array('Recipe.course_id' => $courses[$i]["Course"]["id"])));
            $courses[$i]["Course"]["count"] = $count;
        }
        $this->set('courses', $courses);
        
        $prepMethods = $this->PreparationMethod->find('all');
        for ($i=0; $i < count($prepMethods); $i++) {
            $count = $this->Recipe->find('count', array('conditions' => array('Recipe.preparation_method_id' => $prepMethods[$i]["PreparationMethod"]["id"])));
            $prepMethods[$i]["PreparationMethod"]["count"] = $count;
        }
        $this->set('prepMethods', $prepMethods);
    }
}
?>

