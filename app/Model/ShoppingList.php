<?php
App::uses('AppModel', 'Model');
/**
 * ShoppingListName Model
 *
 * @property User $User
 * @property ShoppingListIngredient $ShoppingListIngredient
 * @property ShoppingListRecipe $ShoppingListRecipe
 */
class ShoppingList extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
            'name' => array(
                    'notEmpty' => array(
                            'rule' => array('notEmpty'),
                            //'message' => 'Your custom message here',
                            //'allowEmpty' => false,
                            //'required' => false,
                            //'last' => false, // Stop validation after this rule
                            //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
            ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
            'User' => array(
                    'className' => 'User',
                    'foreignKey' => 'user_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
            )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ShoppingListIngredient' => array(
                'className' => 'ShoppingListIngredient',
                'foreignKey' => 'shopping_list_id',
                'dependent' => true,
        ),
        'ShoppingListRecipe' => array(
                'className' => 'ShoppingListRecipe',
                'foreignKey' => 'shopping_list_id',
                'dependent' => true,
        )
    );
}
