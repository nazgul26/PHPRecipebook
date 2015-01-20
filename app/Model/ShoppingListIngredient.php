<?php
App::uses('AppModel', 'Model');
/**
 * ShoppingListIngredient Model
 *
 * @property ShoppingListName $ShoppingListName
 * @property Ingredient $Ingredient
 * @property Unit $Unit
 */
class ShoppingListIngredient extends AppModel {
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
        'Ingredient' => array(
            'className' => 'Ingredient',
            'foreignKey' => 'ingredient_id'
        ),
        'Unit' => array(
            'className' => 'Unit',
            'foreignKey' => 'unit_id'
        )
    );
}
