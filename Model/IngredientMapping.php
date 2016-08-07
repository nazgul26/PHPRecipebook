<?php

App::uses('AppModel', 'Model');
/**
 * IngredientMapping Model.
 */
class IngredientMapping extends AppModel
{
    public $belongsTo = [
        'Recipe' => [
                'className'  => 'Recipe',
                'foreignKey' => 'recipe_id',
         ],
        'Ingredient' => [
                'className'  => 'Ingredient',
                'foreignKey' => 'ingredient_id',
        ],
        'Unit' => [
                'className'  => 'Unit',
                'foreignKey' => 'unit_id',
        ],
    ];
}
