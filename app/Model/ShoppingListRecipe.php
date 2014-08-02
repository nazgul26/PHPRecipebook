<?php
App::uses('AppModel', 'Model');
/**
 * ShoppingListRecipe Model
 *
 * @property ShoppingListName $ShoppingListName
 * @property Recipe $Recipe
 */
class ShoppingListRecipe extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShoppingListName' => array(
			'className' => 'ShoppingListName',
			'foreignKey' => 'shopping_list_name_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Recipe' => array(
			'className' => 'Recipe',
			'foreignKey' => 'recipe_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
