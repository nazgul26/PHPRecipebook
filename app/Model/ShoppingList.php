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
                    'notEmpty' => array(
                            'rule' => array('notEmpty'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
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
        return $this->field('id', array('user_id' => $userId, 'name' => __('DEFAULT')));
    }
    
    public function getList($listId, $userId) {
        $this->Behaviors->load('Containable');
        $options = array(
            'contain' => array(
                'ShoppingListRecipe.Recipe'          => array(
                    'fields' => array('name', 'serving_size')
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
        return $this->find('first', array_merge($options, $search));
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
                    'fields' => array('scale'),
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
                list($i, $j) = split('-', $removeId);
                $list[$i][$j]->removed = true;
            }
        }
        return $list;
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
