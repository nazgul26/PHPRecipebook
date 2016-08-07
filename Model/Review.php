<?php

App::uses('AppModel', 'Model');
/**
 * Review Model.
 *
 * @property Recipe $Recipe
 * @property User $User
 */
class Review extends AppModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = [
        'recipe_id' => [
                    'numeric' => [
                        'rule' => 'numeric',
                    ],
        ],
        'comments' => [
                    'required' => [
                        'rule' => 'notBlank',
                    ],
        ],
    ];

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    public $belongsTo = [
            'Recipe' => [
                    'className'  => 'Recipe',
                    'foreignKey' => 'recipe_id',
                    'conditions' => '',
                    'fields'     => '',
                    'order'      => '',
            ],
            'User' => [
                    'className'  => 'User',
                    'foreignKey' => 'user_id',
                    'conditions' => '',
                    'fields'     => '',
                    'order'      => '',
            ],
    ];

    public function isOwnedBy($reviewId, $user)
    {
        return $this->field('id', ['id' => $reviewId, 'user_id' => $user]) !== false;
    }
}
