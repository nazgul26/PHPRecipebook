<?php

App::uses('AppModel', 'Model');
/**
 * RelatedRecipe Model.
 *
 * @property Recipe $Recipe
 */
class RelatedRecipe extends AppModel
{
    public $belongsTo = [
        'Parent' => [
            'className'  => 'Recipe',
            'foreignKey' => 'parent_id',
        ],
        'Related' => [
            'className'  => 'Recipe',
            'foreignKey' => 'recipe_id',
        ],
    ];
}
