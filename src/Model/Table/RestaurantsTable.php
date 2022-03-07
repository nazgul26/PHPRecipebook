<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Restaurants Model
 *
 * @property \App\Model\Table\PriceRangesTable&\Cake\ORM\Association\BelongsTo $PriceRanges
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Restaurant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Restaurant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Restaurant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Restaurant saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Restaurant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant findOrCreate($search, callable $callback = null, $options = [])
 */
class RestaurantsTable extends Table
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

        $this->setTable('restaurants');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('PriceRanges', [
            'foreignKey' => 'price_range_id',
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
            ->scalar('name')
            ->maxLength('name', 64)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('street')
            ->maxLength('street', 128)
            ->allowEmptyString('street');

        $validator
            ->scalar('city')
            ->maxLength('city', 64)
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 2)
            ->allowEmptyString('state');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 16)
            ->allowEmptyString('zip');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 128)
            ->allowEmptyString('phone');

        $validator
            ->scalar('hours')
            ->allowEmptyString('hours');

        $validator
            ->allowEmptyString('picture');

        $validator
            ->scalar('picture_type')
            ->maxLength('picture_type', 64)
            ->allowEmptyString('picture_type');

        $validator
            ->scalar('menu_text')
            ->allowEmptyString('menu_text');

        $validator
            ->scalar('comments')
            ->allowEmptyString('comments');

        $validator
            ->boolean('delivery')
            ->allowEmptyString('delivery');

        $validator
            ->boolean('carry_out')
            ->allowEmptyString('carry_out');

        $validator
            ->boolean('dine_in')
            ->allowEmptyString('dine_in');

        $validator
            ->boolean('credit')
            ->allowEmptyString('credit');

        $validator
            ->scalar('website')
            ->maxLength('website', 254)
            ->allowEmptyString('website');

        $validator
            ->scalar('country')
            ->maxLength('country', 64)
            ->allowEmptyString('country');

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
        $rules->add($rules->existsIn(['price_range_id'], 'PriceRanges'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
