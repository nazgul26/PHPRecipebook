<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShoppingListRecipes Model
 *
 * @property \App\Model\Table\ShoppingListsTable&\Cake\ORM\Association\BelongsTo $ShoppingLists
 * @property \App\Model\Table\RecipesTable&\Cake\ORM\Association\BelongsTo $Recipes
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ShoppingListRecipe get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShoppingListRecipe newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShoppingListRecipe[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingListRecipe|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShoppingListRecipe saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShoppingListRecipe patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingListRecipe[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingListRecipe findOrCreate($search, callable $callback = null, $options = [])
 */
class ShoppingListRecipesTable extends Table
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

        $this->setTable('shopping_list_recipes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ShoppingLists', [
            'foreignKey' => 'shopping_list_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Recipes', [
            'foreignKey' => 'recipe_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('servings')
            ->allowEmptyString('servings');

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
        $rules->add($rules->existsIn(['shopping_list_id'], 'ShoppingLists'));
        $rules->add($rules->existsIn(['recipe_id'], 'Recipes'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    public function getIdToDelete($listId, $itemId, $userId) {
        return $this->find('all')->where([
            'ShoppingListRecipes.shopping_list_id' => $listId,
            'ShoppingListRecipes.recipe_id' => $itemId,
            'ShoppingListRecipes.user_id' => $userId
        ])->first();
    }

    public function addToShoppingList($listId, $recipeId, $servings, $userId) {
        $saveOk = false;
        $existingItem = $this->find()->where(['ShoppingListRecipes.shopping_list_id' => $listId, 'ShoppingListRecipes.user_id' => $userId])->first();
        //$itemId = $this->field('id', array('user_id' => $userId, 'recipe_id' => $recipeId));
        if (isset($existingItem)) {
            // Update Existing
            //$data = $this->find('all', array(
            //    'conditions' => array('ShoppingListRecipes.id' => $itemId)
            //));
            //$data[0]["ShoppingListRecipes"]["servings"] += $servings;
            $existingItem->servings +=$servings;
            $saveOk = $this->save($existingItem);
        } else {
            // Add new
            $item = $this->ShoppingListRecipes->newEntity();
            $newData = array(
                'id' => NULL,
                'shopping_list_id' => $listId,
                'recipe_id' => $recipeId,
                'servings' => $servings,
                'user_id' => $userId
                );
            $item = $this->ShoppingListRecipes->patchEntity($item, $newData);
            $saveOk = $this->ShoppingListRecipes->save($newData);
        }
        
        if ($saveOk) {
            $data = $this->Recipes->find()
                ->select(['id'])
                ->contain([
                    'RelatedRecipes' => [
                        'fields' => ['recipe_id']
                    ]
                ])
                ->where(['Recipes.id' => $recipeId])
                ->first();

            foreach ($data->related_recipes as $related) {
                $relatedRecipeId = $related['recipe_id'];
                $itemId = $this->field('id', array('user_id' => $userId, 'recipe_id' => $relatedRecipeId));
                if (isset($itemId) && $itemId != "") {
                    $data = $this->find()->where(['ShoppingListRecipes.id' => $itemId]);
                    $data[0]["ShoppingListRecipes"]["servings"] += $servings;
                    $saveOk = $this->save($data[0]);
                } else { 
                    $newData = array(
                        'id' => NULL,
                        'shopping_list_id' => $listId,
                        'recipe_id' => $relatedRecipeId,
                        'servings' => $servings,
                        'user_id' => $userId
                    );
                    $saveOk = $this->save($newData);
                }
                if (!$saveOk) break;
            }
        } 
        return $saveOk;
    }
}
