<?php
App::uses('AppModel', 'Model');
/**
 * Store Model
 *
 * @property User $User
 */
class Store extends AppModel {

    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                    'rule' => array('notEmpty'),
            ),
        ),
    );
}
