<?php

App::uses('AppModel', 'Model');
/**
 * PreparationTime Model.
 */
class PreparationTime extends AppModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = [
        'name' => [
                    'required' => [
                        'rule' => 'notBlank',
                    ],
        ],
    ];
}
