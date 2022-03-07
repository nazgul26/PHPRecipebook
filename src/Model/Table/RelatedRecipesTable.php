<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RelatedRecipes Model
 *
 * @property \App\Model\Table\RelatedRecipesTable&\Cake\ORM\Association\BelongsTo $ParentRelatedRecipes
 * @property \App\Model\Table\RecipesTable&\Cake\ORM\Association\BelongsTo $Recipes
 * @property \App\Model\Table\RelatedRecipesTable&\Cake\ORM\Association\HasMany $ChildRelatedRecipes
 *
 * @method \App\Model\Entity\RelatedRecipe get($primaryKey, $options = [])
 * @method \App\Model\Entity\RelatedRecipe newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RelatedRecipe[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RelatedRecipe|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RelatedRecipe saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RelatedRecipe patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RelatedRecipe[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RelatedRecipe findOrCreate($search, callable $callback = null, $options = [])
 */
class RelatedRecipesTable extends Table
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

        $this->setTable('related_recipes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentRelatedRecipes', [
            'className' => 'RelatedRecipes',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsTo('Recipes', [
            'foreignKey' => 'recipe_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ChildRelatedRecipes', [
            'className' => 'RelatedRecipes',
            'foreignKey' => 'parent_id',
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
            ->boolean('required')
            ->allowEmptyString('required');

        $validator
            ->integer('sort_order')
            ->allowEmptyString('sort_order');

        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentRelatedRecipes'));
        $rules->add($rules->existsIn(['recipe_id'], 'Recipes'));

        return $rules;
    }
}
