<?php
App::uses('AppModel', 'Model');
/**
 * VendorProduct Model
 *
 * @property Ingredient $Ingredient
 * @property Vendor $Vendor
 */
class VendorProduct extends AppModel {


    public $validate = array(
            'name' => array(
                    'notBlank' => array(
                            'rule' => array('notBlank'),
                    ),
            ),
            'ingredient_id' => array(
                    'numeric' => array(
                            'rule' => array('numeric'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
            'vendor_id' => array(
                    'numeric' => array(
                            'rule' => array('numeric'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
            'code' => array(
                'notBlank' => array(
                        'rule' => array('notBlank'),
                ),
            ),
    );

    public $belongsTo = array(
        'Ingredient' => array(
                'className' => 'Ingredient',
                'foreignKey' => 'ingredient_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'Vendor' => array(
                'className' => 'Vendor',
                'foreignKey' => 'vendor_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        )
    );
        
    public function isOwnedBy($productId, $user) {
        return $this->field('id', array('id' => $productId, 'user_id' => $user)) !== false;
    }   
}
