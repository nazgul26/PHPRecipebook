<?php
App::uses('AppModel', 'Model');
/**
 * CoreIngredient Model
 *
 * @property Ingredient $Ingredient
 */
class CoreIngredient extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'groupNumber' => array(
			'numeric' => array(
                            'rule' => 'numeric'
			),
		),
		'name' => array(
                    'required' => array(
                        'rule' => 'notBlank'

                    )
		),
		'short_description' => array(
                    'required' => array(
                        'rule' => 'notBlank'
                    )
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Ingredient' => array(
			'className' => 'Ingredient',
			'foreignKey' => 'core_ingredient_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
