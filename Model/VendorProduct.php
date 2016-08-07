<?php

App::uses('AppModel', 'Model');
/**
 * VendorProduct Model.
 *
 * @property Ingredient $Ingredient
 * @property Vendor $Vendor
 */
class VendorProduct extends AppModel
{
    public $validate = [
            'name' => [
                'required' => [
                    'rule' => 'notBlank',
                ],
            ],
            'ingredient_id' => [
                'numeric' => [
                    'rule' => 'numeric',
                ],
            ],
            'vendor_id' => [
                    'numeric' => [
                        'rule' => 'numeric',
                    ],
            ],
            'code' => [
                'required' => [
                    'rule' => 'notBlank',
                ],
            ],
    ];

    public $belongsTo = [
        'Ingredient' => [
                'className'  => 'Ingredient',
                'foreignKey' => 'ingredient_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'Vendor' => [
                'className'  => 'Vendor',
                'foreignKey' => 'vendor_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
    ];

    public function isOwnedBy($productId, $user)
    {
        return $this->field('id', ['id' => $productId, 'user_id' => $user]) !== false;
    }
}
