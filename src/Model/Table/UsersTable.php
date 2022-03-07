<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Users Model
 *
 * @property \App\Model\Table\IngredientsTable&\Cake\ORM\Association\HasMany $Ingredients
 * @property \App\Model\Table\MealPlansTable&\Cake\ORM\Association\HasMany $MealPlans
 * @property \App\Model\Table\RecipesTable&\Cake\ORM\Association\HasMany $Recipes
 * @property \App\Model\Table\RestaurantsTable&\Cake\ORM\Association\HasMany $Restaurants
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 * @property \App\Model\Table\ShoppingListIngredientsTable&\Cake\ORM\Association\HasMany $ShoppingListIngredients
 * @property \App\Model\Table\ShoppingListRecipesTable&\Cake\ORM\Association\HasMany $ShoppingListRecipes
 * @property \App\Model\Table\ShoppingListsTable&\Cake\ORM\Association\HasMany $ShoppingLists
 * @property \App\Model\Table\SourcesTable&\Cake\ORM\Association\HasMany $Sources
 * @property \App\Model\Table\VendorProductsTable&\Cake\ORM\Association\HasMany $VendorProducts
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Ingredients', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('MealPlans', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Recipes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Restaurants', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('ShoppingListIngredients', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('ShoppingListRecipes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('ShoppingLists', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Sources', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('VendorProducts', [
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
            ->scalar('username')
            ->maxLength('username', 32)
            ->requirePresence('username', 'create')
            ->notEmptyString('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->notEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 64)
            ->notEmptyString('name');

        $validator
            ->integer('access_level')
            ->notEmptyString('access_level');

        $validator
            ->scalar('language')
            ->maxLength('language', 8)
            ->notEmptyString('language');

        $validator
            ->scalar('country')
            ->maxLength('country', 8)
            ->notEmptyString('country');

        $validator
            ->dateTime('last_login')
            ->allowEmptyDateTime('last_login');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('reset_token')
            ->maxLength('reset_token', 255)
            ->allowEmptyString('reset_token');

        $validator
            ->boolean('locked')
            ->notEmptyString('locked');

        $validator
            ->dateTime('reset_time')
            ->allowEmptyDateTime('reset_time');

        $validator
            ->integer('meal_plan_start_day')
            ->notEmptyString('meal_plan_start_day');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function isAdmin($user) {
        if ($user == null) return false;

        $adminRole = Configure::read('AuthRoles.admin');
        return $user['access_level'] >= $adminRole;
    }
    
    public function isEditor($user) {
        if ($user == null) return false;
        
        $editorRole = Configure::read('AuthRoles.editor');
        return $user['access_level'] >= $editorRole;
    }
}
