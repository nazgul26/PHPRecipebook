<?php
App::uses('AppModel', 'Model');
/**
 * IngredientMapping Model
 *
 */
class IngredientMapping extends AppModel {
    public $primaryKey = 'recipe_id';
    
    public $belongsTo = array(
        'Recipe' => array(
                    'className' => 'Recipe',
                    'foreignKey' => 'recipe_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
         ),
        'Ingredient' => array(
                    'className' => 'Ingredient',
                    'foreignKey' => 'ingredient_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
        )
    );
}
