<?php
App::uses('AppModel', 'Model');
/**
 * Restaurant Model
 *
 * @property PriceRanges $PriceRanges
 * @property User $User
 */
class Restaurant extends AppModel {

	public $validate = array(
            'name' => array(
                'required' => array(
                    'rule' => 'notBlank'
                )
            )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PriceRange' => array(
			'className' => 'PriceRanges',
			'foreignKey' => 'price_range_id',
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
