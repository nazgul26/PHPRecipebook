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
    
    public function getDefaultListId($userId) {
        return $this->field('id', array('user_id' => $userId, 'name' => __('DEFAULT')));
    }
    
    public function getList($listId, $userId) {
        $this->Behaviors->load('Containable');
        $options = array(
            'contain' => array(
                'ShoppingListRecipe.Recipe'          => array(
                    'fields' => array('name', 'serving_size')
                ),
                'ShoppingListIngredient.Ingredient'
            )
        );

        if ($listId == null) {
            $search = array('conditions' => array('name' => __('DEFAULT'), 
                'user_id' => $userId));
        } else {
            $search = array('conditions' => array('' . $this->primaryKey => $listId, 
                'user_id' => $userId));
        }
        return $this->find('first', array_merge($options, $search));
    }
}
