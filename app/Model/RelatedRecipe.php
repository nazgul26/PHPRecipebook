<?php
App::uses('AppModel', 'Model');
/**
 * RelatedRecipe Model
 *
 * @property Recipe $Recipe
 */
class RelatedRecipe extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	//public $primaryKey = 'n';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
//	public $belongsTo = array(
//		'Recipe' => array(
//			'className' => 'Recipe',
//			'foreignKey' => 'recipe_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
//	);
        
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
