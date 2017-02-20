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
        // Update Existing
        $itemId = $this->field('id', array('user_id' => $userId, 'recipe_id' => $recipeId));
        if (isset($itemId) && $itemId != "") {
            $data = $this->find('all', array(
                'conditions' => array('ShoppingListRecipe.id' => $itemId)
            ));
            $data[0]["ShoppingListRecipe"]["servings"] += $servings;
            $saveOk = $this->save($data[0]);
            return $saveOk;
        }

        // Add new
        $newData = array(
           'id' => NULL,
           'shopping_list_id' => $listId,
           'recipe_id' => $recipeId,
           'servings' => $servings,
           'user_id' => $userId
        );
        $saveOk = $this->save($newData);
        
        if ($saveOk) {
            $this->Recipe->Behaviors->load('Containable');
            $data = $this->Recipe->find('first', array(
                'fields' => array('id'),
                'contain' => array(
                'RelatedRecipe' => array(
                    'fields' => array('recipe_id')
                )
            ),
            'conditions' => array('Recipe.id' => $recipeId)));

            foreach ($data['RelatedRecipe'] as $related) {
                $newData = array(
                    'id' => NULL,
                    'shopping_list_id' => $listId,
                    'recipe_id' => $related['recipe_id'],
                    'servings' => $servings,
                    'user_id' => $userId
                 );
                $saveOk = $this->save($newData);
                if (!$saveOk) break;
            }
        } 
        return $saveOk;
    }
}
