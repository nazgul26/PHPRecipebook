<?php

App::uses('AppModel', 'Model');
/**
 * ShoppingListRecipe Model.
 *
 * @property ShoppingListName $ShoppingListName
 * @property Recipe $Recipe
 */
class ShoppingListRecipe extends AppModel
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
        'Recipe' => [
            'className'  => 'Recipe',
            'foreignKey' => 'recipe_id',
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
                    'ShoppingListRecipe.shopping_list_id' => $listId,
                    'ShoppingListRecipe.user_id'          => $userId,
                    'ShoppingListRecipe.recipe_id'        => $recipeId, ]);
    }

    public function addToShoppingList($listId, $recipeId, $servings, $userId)
    {
        $newData = [
           'id'               => null,
           'shopping_list_id' => $listId,
           'recipe_id'        => $recipeId,
           'servings'         => $servings,
           'user_id'          => $userId,
        ];
        $saveOk = $this->save($newData);

        if ($saveOk) {
            $this->Recipe->Behaviors->load('Containable');
            $data = $this->Recipe->find('first', [
                'fields'  => ['id'],
                'contain' => [
                'RelatedRecipe' => [
                    'fields' => ['recipe_id'],
                ],
            ],
            'conditions' => ['Recipe.id' => $recipeId], ]);

            foreach ($data['RelatedRecipe'] as $related) {
                $newData = [
                    'id'               => null,
                    'shopping_list_id' => $listId,
                    'recipe_id'        => $related['recipe_id'],
                    'servings'         => $servings,
                    'user_id'          => $userId,
                 ];
                $saveOk = $this->save($newData);
                if (!$saveOk) {
                    break;
                }
            }
        }

        return $saveOk;
    }
}
