<?php
App::uses('AppModel', 'Model');
/**
 * RelatedRecipe Model
 *
 * @property Recipe $Recipe
 */
class RelatedRecipe extends AppModel {
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $primaryKey = 'parent_id';

    public $belongsTo = array(
        'Parent' => array(
            'className' => 'Recipe',
            'foreignKey' => 'parent_id'
        ),
        'Related' => array(
            'className' => 'Recipe',
            'foreignKey' => 'recipe_id'
        )
    );
}
