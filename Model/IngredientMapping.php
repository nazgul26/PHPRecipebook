<?php
App::uses('AppModel', 'Model');
/**
 * IngredientMapping Model
 *
 */
class IngredientMapping extends AppModel {    
    public $belongsTo = array(
        'Recipe' => array(
                'className' => 'Recipe',
                'foreignKey' => 'recipe_id'
         ),
        'Ingredient' => array(
                'className' => 'Ingredient',
                'foreignKey' => 'ingredient_id'
        ),
        'Unit' => array(
                'className' => 'Unit',
                'foreignKey' => 'unit_id',
        ),
    );
}
