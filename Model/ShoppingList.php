<?php
App::uses('AppModel', 'Model');
/**
 * ShoppingListName Model
 *
 * @property User $User
 * @property ShoppingListIngredient $ShoppingListIngredient
 * @property ShoppingListRecipe $ShoppingListRecipe
 */
class ShoppingList extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
            'name' => array(
                'required' => array(
                  'rule' => 'notBlank'
                )
            ),
    );

    public $belongsTo = array(
            'User' => array(
                    'className' => 'User',
                    'foreignKey' => 'user_id'
            ),
            'ListItem'
    );

    public $hasMany = array(
        'ShoppingListIngredient' => array(
                'className' => 'ShoppingListIngredient',
                'foreignKey' => 'shopping_list_id',
                'dependent' => true,
        ),
        'ShoppingListRecipe' => array(
                'className' => 'ShoppingListRecipe',
                'foreignKey' => 'shopping_list_id',
                'dependent' => true,
        )
    );
    
    public function getDefaultListId($userId) {
        $listId = $this->field('id', array('user_id' => $userId, 'name' => __('DEFAULT')));
        if (!isset($listId) || $listId == "") {
            echo "going to create list";
            $list = $this->getList($user);
            $listId = $list['ShoppingList']['id'];
        }
        return $listId;
    }
    
    public function getList($userId, $listId=null) {
        $this->Behaviors->load('Containable');
        $options = array(
            'contain' => array(
                'ShoppingListRecipe.Recipe' => array(
                    'fields' => array('id', 'name', 'serving_size')
                ),
                'ShoppingListIngredient.Ingredient'
            )
        );

        if ($listId == null) {
            $search = array('conditions' => array('name' => __('DEFAULT'), 
                'user_id' => $userId));
        } else {
            $search = array('conditions' => array('' . $this->primaryKey => $listId, 
                'user_id' => $userId));
        }
        
        $defaultList = $this->find('first', array_merge($options, $search));
        if (!isset($defaultList['ShoppingList']) || $defaultList['ShoppingList'] == "") {
            $newData = array(
                'id' => NULL,
                'name' => __('DEFAULT'),
                'user_id' => $userId
            );

            if ($this->save($newData)) {
                $defaultList = $this->find('first', array_merge($options, $search));
            }
        }
        // TODO: did not return new ID when call from GetDefaultListId
        return $defaultList;
    }
    
    public function isOwnedBy($listId, $user) {
        return $this->field('id', array('id' => $listId, 'user_id' => $user)) !== false;
    }
    
    /*
     * Get list of ingredients with details.  Loads the current shopping list of the logged
     *  in user.
     */
    public function getAllIngredients($listId, $userId) {
        $this->Behaviors->load('Containable');
        $search = array('conditions' => array('ShoppingList.id'=> $listId, 'ShoppingList.user_id' => $userId),
            'contain' => array( 
                'ShoppingListIngredient' => array(
                    'fields' => array('unit_id', 'quantity'),
                    'Unit' => array(
                        'fields' => array('name')
                    ),
                    'Ingredient' => array(
                        'fields' => array('name', 'location_id')
                    )
                ),
                'ShoppingListRecipe' => array(
                    'fields' => array('servings'),
                    'Recipe' => array(
                        'fields' => array('name'),
                        'IngredientMapping' => array(
                            'fields' => array('quantity'),
                            'Unit' => array(
                                'fields' => array('name')
                            ),
                            'Ingredient' => array(
                                'fields' => array('name', 'location_id')
                            )
                        )
                    )
                )
   
            ));
        
        return $this->find('first', $search);
    }
    
    /*
     * Combines a list of ingredients based on type and converted if possible
     * 
     * @list - Shopping list data provided by 'getAllIngredients'
     */
    public function combineIngredients($list) {
        $ingredients = array();
        
        foreach ($list['ShoppingListIngredient'] as $item) {
            $ingredients = $this->combineIngredient($ingredients, $item);
        }
        foreach ($list['ShoppingListRecipe'] as $recipeInList) {
            $recipeDetail = $recipeInList['Recipe'];
            foreach ($recipeDetail['IngredientMapping'] as $mapping) {
                $ingredients = $this->combineIngredient($ingredients, $mapping);
            }
        }
        
        return ($ingredients);
    }
    
    public function markIngredientsRemoved($list, $removeIds) {
        if (isset($removeIds)) {
            foreach ($removeIds as $removeId) {
                list($i, $j) = explode('-', $removeId);
                $list[$i][$j]->removed = true;
            }
        }
        return $list;
    } 
    
    /*
     * Clears all ingredients and recipes from the given shopping list.
     */
    public function clearList($userId) {
        $this->ShoppingListIngredient->deleteAll(array('ShoppingListIngredient.user_id' => $userId), false);
        $this->ShoppingListRecipe->deleteAll(array('ShoppingListRecipe.user_id' => $userId), false);
    }
    
    private function combineIngredient($list, $ingredient) {
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
            $list[$id] = array(clone $this->ListItem);
        }
        return $list;
    }
}
