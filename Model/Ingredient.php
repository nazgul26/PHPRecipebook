<?php

App::uses('AppModel', 'Model');
/**
 * Ingredient Model.
 *
 * @property Location $Location
 * @property Unit $Unit
 * @property User $User
 */
class Ingredient extends AppModel
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
     * belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
            'Location' => [
                    'className'  => 'Location',
                    'foreignKey' => 'location_id',
            ],
            'Unit' => [
                    'className'  => 'Unit',
                    'foreignKey' => 'unit_id',
            ],
            'User' => [
                    'className'  => 'User',
                    'foreignKey' => 'user_id',
            ],
    ];

    public $hasMany = [
        'IngredientMapping' => [
            'className'  => 'IngredientMapping',
            'foreignKey' => 'ingredient_id',
            'order'      => 'IngredientMapping.sort_order',
            'dependent'  => true,
        ],
    ];

    public function isOwnedBy($ingredientId, $user)
    {
        return $this->field('id', ['id' => $ingredientId, 'user_id' => $user]) !== false;
    }
}
