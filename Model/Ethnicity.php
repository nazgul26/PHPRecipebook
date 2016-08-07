<?php

App::uses('AppModel', 'Model');
/**
 * Ethnicity Model.
 */
class Ethnicity extends AppModel
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
