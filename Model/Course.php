<?php
App::uses('AppModel', 'Model');
/**
 * Course Model
 *
 */
class Course extends AppModel {

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
