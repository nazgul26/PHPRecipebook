<?php
App::uses('AppModel', 'Model');
/**
 * RelatedRecipe Model
 *
 * @property Recipe $Recipe
 */
class RelatedRecipe extends AppModel {
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
