<?php

App::uses('AppModel', 'Model');
/**
 * Source Model.
 *
 * @property User $User
 */
class Source extends AppModel
{
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
        'User' => [
            'className'  => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => '',
        ],
    ];
}
