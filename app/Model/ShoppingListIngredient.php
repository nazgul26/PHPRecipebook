<?php
App::uses('AppModel', 'Model');
/**
 * ShoppingListIngredient Model
 *
 * @property ShoppingListName $ShoppingListName
 * @property Ingredient $Ingredient
 * @property Unit $Unit
 */
class ShoppingListIngredient extends AppModel {


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
		'Ingredient' => array(
			'className' => 'Ingredient',
			'foreignKey' => 'ingredient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Unit' => array(
			'className' => 'Unit',
			'foreignKey' => 'unit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
