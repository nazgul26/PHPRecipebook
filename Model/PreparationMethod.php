<?php

App::uses('AppModel', 'Model');
/**
 * PreparationMethod Model.
 *
 * @property Recipe $Recipe
 */
class PreparationMethod extends AppModel
{
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations.
     *
     * @var array
     */
    public $hasMany = [
        'Recipe' => [
            'className'    => 'Recipe',
            'foreignKey'   => 'preparation_method_id',
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
