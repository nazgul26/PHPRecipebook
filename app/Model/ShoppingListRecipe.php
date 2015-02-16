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
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    
    public function getIdToDelete($listId, $recipeId, $userId) {
        return $this->field('id',
                array(
                    'ShoppingListRecipe.shopping_list_id' => $listId,
                    'ShoppingListRecipe.user_id' => $userId,
                    'ShoppingListRecipe.recipe_id' => $recipeId));
    }
    
    public function addToShoppingList($listId, $recipeId, $servings, $userId) {
        $newData = array(
           'id' => NULL,
           'shopping_list_id' => $listId,
           'recipe_id' => $recipeId,
           'servings' => $servings,
           'user_id' => $userId
        );

        return $this->save($newData);
    }
}
