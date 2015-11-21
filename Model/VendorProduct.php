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
                'required' => array(
                    'rule' => 'notBlank'
                )
            ),
            'ingredient_id' => array(
                'numeric' => array(
                    'rule' => 'numeric'
                )
            ),
            'vendor_id' => array(
                    'numeric' => array(
                        'rule' => 'numeric'
                    ),
            ),
            'code' => array(
                'required' => array(
                    'rule' => 'notBlank'
                )
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
