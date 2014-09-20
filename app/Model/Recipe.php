<?php
App::uses('AppModel', 'Model');
/**
 * Recipe Model
 *
 * @property Ethnicity $Ethnicity
 * @property BaseType $BaseType
 * @property Course $Course
 * @property PreparationTime $PreparationTime
 * @property Difficulty $Difficulty
 * @property Source $Source
 * @property User $User
 */
class Recipe extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'private' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'system' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ethnicity' => array(
			'className' => 'Ethnicity',
			'foreignKey' => 'ethnicity_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BaseType' => array(
			'className' => 'BaseType',
			'foreignKey' => 'base_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PreparationTime' => array(
			'className' => 'PreparationTime',
			'foreignKey' => 'preparation_time_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'PreparationMethod' => array(
			'className' => 'PreparationMethod',
			'foreignKey' => 'preparation_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Difficulty' => array(
			'className' => 'Difficulty',
			'foreignKey' => 'difficulty_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Source' => array(
			'className' => 'Source',
			'foreignKey' => 'source_id',
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
        
        public $hasMany = array(
            'RelatedRecipe' => array(
                'className' => 'RelatedRecipe',
                'foreignKey' => 'recipe_id'
            )
        );
}
