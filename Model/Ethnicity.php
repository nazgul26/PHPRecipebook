<?php
App::uses('AppModel', 'Model');
/**
 * Ethnicity Model
 *
 */
class Ethnicity extends AppModel {

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
	);
}
