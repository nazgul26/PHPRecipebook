<?php
App::uses('AppController', 'Controller');
class RecipeLinkBoxController extends AppController {
    public $uses = array(
        'BaseType',
        'Course',
        'Recipe'
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
    }
}
?>

