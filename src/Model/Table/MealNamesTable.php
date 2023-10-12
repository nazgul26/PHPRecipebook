<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MealNames Model
 *
 * @property \App\Model\Table\MealPlansTable&\Cake\ORM\Association\HasMany $MealPlans
 *
 * @method \App\Model\Entity\MealName get($primaryKey, $options = [])
 * @method \App\Model\Entity\MealName newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MealName[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MealName|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MealName saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MealName patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MealName[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MealName findOrCreate($search, callable $callback = null, $options = [])
 */
class MealNamesTable extends Table
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

        $this->setTable('meal_names');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('MealPlans', [
            'foreignKey' => 'meal_name_id',
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
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
