<?php
App::uses('AppModel', 'Model');
/**
 * ShoppingListRecipe Model
 *
 * @property ShoppingListName $ShoppingListName
 * @property Recipe $Recipe
 */
class ShoppingListRecipe extends AppModel {
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'ShoppingList' => array(
            'className' => 'ShoppingList',
            'foreignKey' => 'shopping_list_id'
        ),
        'Recipe' => array(
            'className' => 'Recipe',
            'foreignKey' => 'recipe_id'
        )
    );
}
