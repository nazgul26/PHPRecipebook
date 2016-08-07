<?php

App::uses('AppModel', 'Model');
/**
 * ShoppingListIngredient Model.
 *
 * @property ShoppingListName $ShoppingListName
 * @property Ingredient $Ingredient
 * @property Unit $Unit
 */
class ShoppingListIngredient extends AppModel
{
    /**
     * belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
        'ShoppingList' => [
            'className'  => 'ShoppingList',
            'foreignKey' => 'shopping_list_id',
        ],
        'Ingredient' => [
            'className'  => 'Ingredient',
            'foreignKey' => 'ingredient_id',
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

    public function getIdToDelete($listId, $recipeId, $userId)
    {
        return $this->field('id',
                [
                    'ShoppingListIngredient.shopping_list_id' => $listId,
                    'ShoppingListIngredient.user_id'          => $userId,
                    'ShoppingListIngredient.ingredient_id'    => $recipeId, ]);
    }
}
