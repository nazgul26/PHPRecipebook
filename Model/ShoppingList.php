<?php

App::uses('AppModel', 'Model');
/**
 * ShoppingListName Model.
 *
 * @property User $User
 * @property ShoppingListIngredient $ShoppingListIngredient
 * @property ShoppingListRecipe $ShoppingListRecipe
 */
class ShoppingList extends AppModel
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

    public $belongsTo = [
            'User' => [
                    'className'  => 'User',
                    'foreignKey' => 'user_id',
            ],
            'ListItem',
    ];

    public $hasMany = [
        'ShoppingListIngredient' => [
                'className'  => 'ShoppingListIngredient',
                'foreignKey' => 'shopping_list_id',
                'dependent'  => true,
        ],
        'ShoppingListRecipe' => [
                'className'  => 'ShoppingListRecipe',
                'foreignKey' => 'shopping_list_id',
                'dependent'  => true,
        ],
    ];

    public function getDefaultListId($userId)
    {
        $listId = $this->field('id', ['user_id' => $userId, 'name' => __('DEFAULT')]);
        if (!isset($listId) || $listId == '') {
            echo 'going to create list';
            $list = $this->getList($user);
            $listId = $list['ShoppingList']['id'];
        }

        return $listId;
    }

    public function getList($userId, $listId = null)
    {
        $this->Behaviors->load('Containable');
        $options = [
            'contain' => [
                'ShoppingListRecipe.Recipe' => [
                    'fields' => ['id', 'name', 'serving_size'],
                ],
                'ShoppingListIngredient.Ingredient',
            ],
        ];

        if ($listId == null) {
            $search = ['conditions' => ['name' => __('DEFAULT'),
                'user_id'                      => $userId, ]];
        } else {
            $search = ['conditions' => [''.$this->primaryKey => $listId,
                'user_id'                                    => $userId, ]];
        }

        $defaultList = $this->find('first', array_merge($options, $search));
        if (!isset($defaultList['ShoppingList']) || $defaultList['ShoppingList'] == '') {
            $newData = [
                'id'      => null,
                'name'    => __('DEFAULT'),
                'user_id' => $userId,
            ];

            if ($this->save($newData)) {
                $defaultList = $this->find('first', array_merge($options, $search));
            }
        }
        // TODO: did not return new ID when call from GetDefaultListId
        return $defaultList;
    }

    public function isOwnedBy($listId, $user)
    {
        return $this->field('id', ['id' => $listId, 'user_id' => $user]) !== false;
    }

    /*
     * Get list of ingredients with details.  Loads the current shopping list of the logged
     *  in user.
     */
    public function getAllIngredients($listId, $userId)
    {
        $this->Behaviors->load('Containable');
        $search = ['conditions' => ['ShoppingList.id' => $listId, 'ShoppingList.user_id' => $userId],
            'contain'           => [
                'ShoppingListIngredient' => [
                    'fields' => ['unit_id', 'quantity'],
                    'Unit'   => [
                        'fields' => ['name'],
                    ],
                    'Ingredient' => [
                        'fields' => ['name', 'location_id'],
                    ],
                ],
                'ShoppingListRecipe' => [
                    'fields' => ['servings'],
                    'Recipe' => [
                        'fields'            => ['name'],
                        'IngredientMapping' => [
                            'fields' => ['quantity'],
                            'Unit'   => [
                                'fields' => ['name'],
                            ],
                            'Ingredient' => [
                                'fields' => ['name', 'location_id'],
                            ],
                        ],
                    ],
                ],

            ], ];

        return $this->find('first', $search);
    }

    /*
     * Combines a list of ingredients based on type and converted if possible
     *
     * @list - Shopping list data provided by 'getAllIngredients'
     */
    public function combineIngredients($list)
    {
        $ingredients = [];

        foreach ($list['ShoppingListIngredient'] as $item) {
            $ingredients = $this->combineIngredient($ingredients, $item);
        }
        foreach ($list['ShoppingListRecipe'] as $recipeInList) {
            $recipeDetail = $recipeInList['Recipe'];
            foreach ($recipeDetail['IngredientMapping'] as $mapping) {
                $ingredients = $this->combineIngredient($ingredients, $mapping);
            }
        }

        return $ingredients;
    }

    public function markIngredientsRemoved($list, $removeIds)
    {
        if (isset($removeIds)) {
            foreach ($removeIds as $removeId) {
                list($i, $j) = split('-', $removeId);
                $list[$i][$j]->removed = true;
            }
        }

        return $list;
    }

    /*
     * Clears all ingredients and recipes from the given shopping list.
     */
    public function clearList($userId)
    {
        $this->ShoppingListIngredient->deleteAll(['ShoppingListIngredient.user_id' => $userId], false);
        $this->ShoppingListRecipe->deleteAll(['ShoppingListRecipe.user_id' => $userId], false);
    }

    private function combineIngredient($list, $ingredient)
    {
        $id = $ingredient['ingredient_id'];
        $unitId = $ingredient['unit_id'];
        $quantity = $ingredient['quantity'];
        $name = $ingredient['Ingredient']['name'];
        $locationId = $ingredient['Ingredient']['location_id'];
        $unitName = $ingredient['Unit']['name'];
        if (isset($list[$id])) {
            foreach ($list[$id] as $item) {
                if ($item->unitId == $unitId) {
                    $item->quantity += $quantity;
                }
            }
        } else {
            $this->ListItem->id = $id;
            $this->ListItem->name = $name;
            $this->ListItem->unitId = $unitId;
            $this->ListItem->quantity = $quantity;
            $this->ListItem->unitName = $unitName;
            $this->ListItem->locationId = $locationId;
            $this->ListItem->removed = false;
            $list[$id] = [clone $this->ListItem];
        }

        return $list;
    }
}
