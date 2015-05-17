<?php
App::uses('AppModel', 'Model');
/**
 * Review Model
 *
 * @property Recipe $Recipe
 * @property User $User
 */
class Review extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'comments' => array(
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

    public $belongsTo = array(
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
    
    public function isOwnedBy($reviewId, $user) {
        return $this->field('id', array('id' => $reviewId, 'user_id' => $user)) !== false;
    }
}
