<?php
App::uses('AppModel', 'Model');
/**
 * Vendor Model
 *
 * @property VendorProduct $VendorProduct
 */
class Vendor extends AppModel {
    
	public $validate = array(
            'name' => array(
                'required' => array(
                    'rule' => 'notBlank'
                )
            )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'VendorProduct' => array(
			'className' => 'VendorProduct',
			'foreignKey' => 'vendor_id',
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
