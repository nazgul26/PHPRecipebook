<?php

App::uses('AppModel', 'Model');
/**
 * Unit Model.
 */
class Unit extends AppModel
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
        'abbreviation' => [
                    'required' => [
                        'rule' => 'notBlank',
                    ],
        ],
        'system' => [
                    'numeric' => [
                            'rule' => 'numeric',
                    ],
        ],
        'sort_order' => [
                    'numeric' => [
                        'rule' => 'numeric',
                    ],
        ],
    ];
}
