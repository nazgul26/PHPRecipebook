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
                        'rule' => 'numeric'
                    )
		),
		'comments' => array(
                    'required' => array(
                        'rule' => 'notBlank'
                    )
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
