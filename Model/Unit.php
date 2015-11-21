<?php
App::uses('AppModel', 'Model');
/**
 * Unit Model
 *
 */
class Unit extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
                    'required' => array(
                        'rule' => 'notBlank'
                    )
		),
		'abbreviation' => array(
                    'required' => array(
                        'rule' => 'notBlank'
                    )
		),
		'system' => array(
                    'numeric' => array(
                            'rule' => 'numeric'
                    )
		),
		'sort_order' => array(
                    'numeric' => array(
                        'rule' => 'numeric'
                    )
		),
	);
}
