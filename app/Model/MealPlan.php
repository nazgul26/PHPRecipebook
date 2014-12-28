<?php
App::uses('AppModel', 'Model');
/**
 * MealPlan Model
 *
 * @property MealName $MealName
 * @property Recipe $Recipe
 * @property User $User
 */
class MealPlan extends AppModel {

    public $DaysAbbreviated = array(
        'Sun',
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat');
    
    public $DaysFull = array(
       'Sunday',
       'Monday',
       'Tuesday',
       'Wednesday',
       'Thursday',
       'Friday',
       'Saturday');
    
    public $MonthsAbbreviated = array(
        'Jan',
	'Feb',
	'Mar',
	'Apr',
	'May',
	'Jun',
	'Jul',
	'Aug',
	'Sep',
	'Oct',
	'Nov',
	'Dec');
    
    public $MonthsFull = array(
        'January',
	'February',
	'March',
	'April',
	'May',
	'June',
	'July',
	'August',
	'September',
	'October',
	'November',
	'December');
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'mealday' => array(
                'date' => array(
                        'rule' => array('date'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
        ),
        'meal_name_id' => array(
                'numeric' => array(
                        'rule' => array('numeric'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
        ),
        'recipe_id' => array(
                'numeric' => array(
                        'rule' => array('numeric'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
        ),
        'servings' => array(
                'numeric' => array(
                        'rule' => array('numeric'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
        ),
    );


    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'MealName' => array(
                'className' => 'MealName',
                'foreignKey' => 'meal_name_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'Recipe' => array(
                'className' => 'Recipe',
                'foreignKey' => 'recipe_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        )
    );
}
