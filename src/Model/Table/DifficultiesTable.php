<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Difficulties Model
 *
 * @property \App\Model\Table\RecipesTable&\Cake\ORM\Association\HasMany $Recipes
 *
 * @method \App\Model\Entity\Difficulty get($primaryKey, $options = [])
 * @method \App\Model\Entity\Difficulty newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Difficulty[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Difficulty|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Difficulty saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Difficulty patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Difficulty[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Difficulty findOrCreate($search, callable $callback = null, $options = [])
 */
class DifficultiesTable extends Table
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

        $this->setTable('difficulties');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Recipes', [
            'foreignKey' => 'difficulty_id',
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
            ->allowEmptyString('name');

        return $validator;
    }
}
