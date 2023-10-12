<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PriceRanges Model
 *
 * @property \App\Model\Table\RestaurantsTable&\Cake\ORM\Association\HasMany $Restaurants
 *
 * @method \App\Model\Entity\PriceRange get($primaryKey, $options = [])
 * @method \App\Model\Entity\PriceRange newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PriceRange[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PriceRange|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PriceRange saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PriceRange patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PriceRange[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PriceRange findOrCreate($search, callable $callback = null, $options = [])
 */
class PriceRangesTable extends Table
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

        $this->setTable('price_ranges');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Restaurants', [
            'foreignKey' => 'price_range_id',
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
            ->maxLength('name', 16)
            ->allowEmptyString('name')
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
