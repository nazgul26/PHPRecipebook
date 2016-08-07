<?php

App::uses('AppModel', 'Model');
/**
 * BaseType Model.
 *
 * @property Recipe $Recipe
 */
class BaseType extends AppModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = [
        'name' => [
                    'required' => [
                        'rule' => 'notBlank',
                    ],
        ],
    ];

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations.
     *
     * @var array
     */
    public $hasMany = [
        'Recipe' => [
            'className'    => 'Recipe',
            'foreignKey'   => 'base_type_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => '',
        ],
    ];
}
