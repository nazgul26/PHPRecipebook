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
            'required' => array(
                'rule' => 'notBlank'
            )
        ),
    );
}
