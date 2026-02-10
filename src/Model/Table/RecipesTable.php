<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class RecipesTable extends Table
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

        $this->setTable('recipes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ethnicities', [
            'foreignKey' => 'ethnicity_id',
        ]);
        $this->belongsTo('BaseTypes', [
            'foreignKey' => 'base_type_id',
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
        ]);
        $this->belongsTo('PreparationTimes', [
            'foreignKey' => 'preparation_time_id',
        ]);
        $this->belongsTo('Difficulties', [
            'foreignKey' => 'difficulty_id',
        ]);
        $this->belongsTo('Sources', [
            'foreignKey' => 'source_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('PreparationMethods', [
            'foreignKey' => 'preparation_method_id',
        ]);
        $this->hasMany('Attachments', [
            'foreignKey' => 'recipe_id',
        ]);
        $this->hasMany('IngredientMappings', [
            'foreignKey' => 'recipe_id',
        ]);
        $this->hasMany('MealPlans', [
            'foreignKey' => 'recipe_id',
        ]);
        $this->hasMany('RelatedRecipes', [
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'recipe_id',
        ]);
        $this->hasMany('ShoppingListRecipes', [
            'foreignKey' => 'recipe_id',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'recipe_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'recipes_tags',
            'saveStrategy' => 'replace',
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
            ->maxLength('name', 128)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('serving_size')
            ->allowEmptyString('serving_size');

        $validator
            ->scalar('directions')
            ->maxLength('directions', 4294967295)
            ->allowEmptyString('directions');

        $validator
            ->scalar('comments')
            ->maxLength('comments', 16777215)
            ->allowEmptyString('comments');

        $validator
            ->scalar('source_description')
            ->maxLength('source_description', 200)
            ->allowEmptyString('source_description');

        $validator
            ->numeric('recipe_cost')
            ->allowEmptyString('recipe_cost');

        $validator
            ->allowEmptyString('picture');

        $validator
            ->scalar('picture_type')
            ->maxLength('picture_type', 32)
            ->allowEmptyString('picture_type');

        $validator
            ->boolean('private')
            ->requirePresence('private', 'create')
            ->notEmptyString('private');

        $validator
            ->scalar('system_type')
            ->maxLength('system_type', 16)
            ->notEmptyString('system_type');

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
        $rules->add($rules->existsIn(['ethnicity_id'], 'Ethnicities'));
        $rules->add($rules->existsIn(['base_type_id'], 'BaseTypes'));
        $rules->add($rules->existsIn(['course_id'], 'Courses'));
        $rules->add($rules->existsIn(['preparation_time_id'], 'PreparationTimes'));
        $rules->add($rules->existsIn(['difficulty_id'], 'Difficulties'));
        $rules->add($rules->existsIn(['source_id'], 'Sources'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['preparation_method_id'], 'PreparationMethods'));

        return $rules;
    }
}
