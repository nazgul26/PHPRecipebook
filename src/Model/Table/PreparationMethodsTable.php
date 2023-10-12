<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PreparationMethods Model
 *
 * @property \App\Model\Table\RecipesTable&\Cake\ORM\Association\HasMany $Recipes
 *
 * @method \App\Model\Entity\PreparationMethod get($primaryKey, $options = [])
 * @method \App\Model\Entity\PreparationMethod newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PreparationMethod[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PreparationMethod|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PreparationMethod saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PreparationMethod patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PreparationMethod[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PreparationMethod findOrCreate($search, callable $callback = null, $options = [])
 */
class PreparationMethodsTable extends Table
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

        $this->setTable('preparation_methods');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Recipes', [
            'foreignKey' => 'preparation_method_id',
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
            ->allowEmptyString('name');

        return $validator;
    }
}
