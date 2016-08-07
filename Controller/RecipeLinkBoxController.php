<?php
App::uses('AppController', 'Controller');
class RecipeLinkBoxController extends AppController
{
    public $uses = [
        'BaseType',
        'Course',
        'Recipe',
        'PreparationMethod',
    ];

    public function index()
    {
        //TODO: make this a setting to filter out mine (probably remember last login to get ID)
        //$userFilter = array('Recipe.user_id' => $this->Auth->user('id'));
        $userFilter = [];

        $this->layout = 'ajax';
        $baseTypes = $this->BaseType->find('all');
        for ($i = 0; $i < count($baseTypes); $i++) {
            $count = $this->Recipe->find('count', ['conditions' => array_merge($userFilter, ['Recipe.base_type_id' => $baseTypes[$i]['BaseType']['id']])]);
            $baseTypes[$i]['BaseType']['count'] = $count;
        }
        $this->set('baseTypes', $baseTypes);

        $courses = $this->Course->find('all');
        for ($i = 0; $i < count($courses); $i++) {
            $count = $this->Recipe->find('count', ['conditions' => array_merge($userFilter, ['Recipe.course_id' => $courses[$i]['Course']['id']])]);
            $courses[$i]['Course']['count'] = $count;
        }
        $this->set('courses', $courses);

        $prepMethods = $this->PreparationMethod->find('all');
        for ($i = 0; $i < count($prepMethods); $i++) {
            $count = $this->Recipe->find('count', ['conditions' => array_merge($userFilter, ['Recipe.preparation_method_id' => $prepMethods[$i]['PreparationMethod']['id']])]);
            $prepMethods[$i]['PreparationMethod']['count'] = $count;
        }
        $this->set('prepMethods', $prepMethods);
    }
}
?>

