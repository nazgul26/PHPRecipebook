<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class RecipesTagsTable extends Table
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

        $this->setTable('recipes_tags');
        $this->setPrimaryKey(['recipe_id', 'tag_id']);

        $this->belongsTo('Recipes', [
            'foreignKey' => 'recipe_id',
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
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
            ->integer('recipe_id')
            ->requirePresence('recipe_id', 'create')
            ->notEmptyString('recipe_id');

        $validator
            ->integer('tag_id')
            ->requirePresence('tag_id', 'create')
            ->notEmptyString('tag_id');

        return $validator;
    }
}
