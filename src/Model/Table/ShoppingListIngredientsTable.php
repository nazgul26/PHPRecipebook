<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShoppingListIngredients Model
 *
 * @property \App\Model\Table\ShoppingListsTable&\Cake\ORM\Association\BelongsTo $ShoppingLists
 * @property \App\Model\Table\IngredientsTable&\Cake\ORM\Association\BelongsTo $Ingredients
 * @property \App\Model\Table\UnitsTable&\Cake\ORM\Association\BelongsTo $Units
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ShoppingListIngredient get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShoppingListIngredient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShoppingListIngredient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingListIngredient|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShoppingListIngredient saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShoppingListIngredient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingListIngredient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShoppingListIngredient findOrCreate($search, callable $callback = null, $options = [])
 */
class ShoppingListIngredientsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('shopping_list_ingredients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ShoppingLists', [
            'foreignKey' => 'shopping_list_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Ingredients', [
            'foreignKey' => 'ingredient_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id',
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('qualifier')
            ->maxLength('qualifier', 32)
            ->allowEmptyString('qualifier');

        $validator
            ->numeric('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['shopping_list_id'], 'ShoppingLists'));
        $rules->add($rules->existsIn(['ingredient_id'], 'Ingredients'));
        $rules->add($rules->existsIn(['unit_id'], 'Units'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /* 
     * Returns the Ingredient if the user and list ID are valid and allowed.
    */
    public function getIdToDelete($listId, $itemId, $userId) {
        return $this->find('all')->where([
            'ShoppingListIngredients.shopping_list_id' => $listId,
            'ShoppingListIngredients.id' => $itemId,
            'ShoppingListIngredients.user_id' => $userId
        ])->first();
    }
}
