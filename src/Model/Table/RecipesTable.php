<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Recipes Model
 *
 * @property \App\Model\Table\EthnicitiesTable&\Cake\ORM\Association\BelongsTo $Ethnicities
 * @property \App\Model\Table\BaseTypesTable&\Cake\ORM\Association\BelongsTo $BaseTypes
 * @property \App\Model\Table\CoursesTable&\Cake\ORM\Association\BelongsTo $Courses
 * @property \App\Model\Table\PreparationTimesTable&\Cake\ORM\Association\BelongsTo $PreparationTimes
 * @property \App\Model\Table\DifficultiesTable&\Cake\ORM\Association\BelongsTo $Difficulties
 * @property \App\Model\Table\SourcesTable&\Cake\ORM\Association\BelongsTo $Sources
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PreparationMethodsTable&\Cake\ORM\Association\BelongsTo $PreparationMethods
 * @property \App\Model\Table\AttachmentsTable&\Cake\ORM\Association\HasMany $Attachments
 * @property \App\Model\Table\IngredientMappingsTable&\Cake\ORM\Association\HasMany $IngredientMappings
 * @property \App\Model\Table\MealPlansTable&\Cake\ORM\Association\HasMany $MealPlans
 * @property \App\Model\Table\RelatedRecipesTable&\Cake\ORM\Association\HasMany $RelatedRecipes
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 * @property \App\Model\Table\ShoppingListRecipesTable&\Cake\ORM\Association\HasMany $ShoppingListRecipes
 *
 * @method \App\Model\Entity\Recipe get($primaryKey, $options = [])
 * @method \App\Model\Entity\Recipe newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Recipe[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Recipe|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Recipe saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Recipe patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Recipe[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Recipe findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecipesTable extends Table
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
            'foreignKey' => 'recipe_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'recipe_id',
        ]);
        $this->hasMany('ShoppingListRecipes', [
            'foreignKey' => 'recipe_id',
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
            ->scalar('system')
            ->maxLength('system', 16)
            ->notEmptyString('system');

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
