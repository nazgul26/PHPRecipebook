<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\ListItem;

/**
 * ShoppingLists Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ShoppingListIngredientsTable&\Cake\ORM\Association\HasMany $ShoppingListIngredients
 * @property \App\Model\Table\ShoppingListRecipesTable&\Cake\ORM\Association\HasMany $ShoppingListRecipes
 *
 * @method \App\Model\Entity\ShoppingList get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShoppingList newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShoppingList[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingList|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShoppingList saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShoppingList patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingList[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingList findOrCreate($search, callable $callback = null, $options = [])
 */
class ShoppingListsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('shopping_lists');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);

        //$this->belongsTo('ListItems', [        ]);

        $this->hasMany('ShoppingListIngredients', [
            'foreignKey' => 'shopping_list_id',
        ]);
        $this->hasMany('ShoppingListRecipes', [
            'foreignKey' => 'shopping_list_id',
        ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) : Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 64)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) : RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /*public function getDefaultListId($userId) {
        $listId = $this->field('id', array('user_id' => $userId, 'name' => __('DEFAULT')));
        if (!isset($listId) || $listId == "") {
            $list = $this->getList($user);
            $listId = $list['ShoppingList']['id'];
        }
        return $listId;
    }*/
    
    public function getList($userId, $listId=null) {
        $containOptions = [
            'ShoppingListRecipes.Recipes' => [
                'fields' => ['id', 'name', 'serving_size']
            ],
            'ShoppingListIngredients.Ingredients' //TODO: ADD ASSOCIATION
        ];

        if ($listId == null) {
            $conditions = [
                'name' => __('DEFAULT'),
                'user_id' => $userId
            ];
        } else {
            $conditions = [
                'id' => $listId,
                'user_id' => $userId
            ];
        }

        $defaultList = $this->find()
            ->contain($containOptions)
            ->where($conditions)
            ->limit(1);

        if (!isset($defaultList)) {
            $newData = array(
                'id' => NULL,
                'name' => __('DEFAULT'),
                'user_id' => $userId
            );

            if ($this->save($newData)) {
                $defaultList = $this->find()
                    ->contain($containOptions)
                    ->where($conditions)
                    ->limit(1);
            }
        }

        // TODO: did not return new ID when call from GetDefaultListId
        return $defaultList->first();
    }
    
    public function isOwnedBy($listId, $user) {
        return $this->field('id', array('id' => $listId, 'user_id' => $user)) !== false;
    }
    
    /*
     * Get list of ingredients with details.  Loads the current shopping list of the logged
     *  in user.
     */
    public function getAllIngredients($listId, $userId) {
        return $this->find()
            ->where(['ShoppingLists.id' => $listId, 'ShoppingLists.user_id' => $userId])
            ->contain([
                'ShoppingListIngredients' => [
                    'fields' => ['shopping_list_id', 'unit_id', 'quantity'],
                    'Units' => [
                        'fields' => ['name']
                    ],
                    'Ingredients' => [
                        'fields' => ['id', 'name', 'location_id']
                    ]
                ],
                'ShoppingListRecipes' => [
                    'fields' => ['servings', 'shopping_list_id'],
                    'Recipes' => [
                        'fields' => ['id', 'name', 'serving_size'],
                        'IngredientMappings' => [
                            'fields' => ['recipe_id', 'quantity'],
                            'Units' => [
                                'fields' => ['name']
                            ],
                            'Ingredients' => [
                                'fields' => ['id', 'name', 'location_id']
                            ]
                        ]
                    ]
                ]
            ])
            ->first();
    }
    
    /*
     * Combines a list of ingredients based on type and converted if possible
     * 
     * @list - Shopping list data provided by 'getAllIngredients'
     */
    public function combineIngredients($list) {
        $ingredients = [];
        foreach ($list->shopping_list_ingredients as $item) {
            //TODO: pass on servings
            $ingredients = $this->combineIngredient($ingredients, $item, 1);
        }
        foreach ($list->shopping_list_recipes as $recipeInList) {
            $recipeDetail = $recipeInList->recipe;
            $scaling = $recipeInList->servings / $recipeDetail->serving_size;
            foreach ($recipeDetail->ingredient_mappings as $mapping) {
                $ingredients = $this->combineIngredient($ingredients, $mapping, $scaling);
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
        $this->ShoppingListIngredients->deleteAll(['ShoppingListIngredients.user_id' => $userId], false);
        $this->ShoppingListRecipes->deleteAll(['ShoppingListRecipes.user_id' => $userId], false);
    }
    
    private function combineIngredient($list, $ingredient, $scaling) {
        $id = $ingredient->ingredient->id;
        $unitId = $ingredient->unit->id;
        $quantity = $ingredient->quantity;
        $name = $ingredient->ingredient->name;
        $locationId = $ingredient->ingredient->location_id;
        $unitName = $ingredient->unit->name;

        if (isset($list[$id])) {
            foreach ($list[$id] as $item) {
                if ($item->unitId == $unitId) {
                    $item->quantity += $quantity * $scaling;
                }
            }
        } else {
            $item = new ListItem();
            $item->id = $id;
            $item->name = $name;
            $item->unitId = $unitId;
            $item->quantity = $quantity * $scaling;
            $item->unitName = $unitName;
            $item->locationId = $locationId;
            $item->removed = false;
            $list[$id] = array(clone $item);
        }
        return $list;
    }
}
