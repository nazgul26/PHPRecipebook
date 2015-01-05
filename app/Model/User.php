<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 */
class User extends AppModel {

    public $validate = array(
        'username' => array(
            'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'allowEmpty' => false,
                    'required' => true
            ),
        ),
        // Turned off to allow Edit and not re-encrypt
        'password' => array(
            'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'allowEmpty' => false,
                    'required' => true,
                    'on' => 'create'
            ),
        ),
        'name' => array(
            'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'allowEmpty' => false,
                    'required' => true
            ),
        ),
        'access_level' => array(
            'numeric' => array(
                    'rule' => array('numeric'),
                    'allowEmpty' => false,
                    'required' => true
            ),
        ),
        'language' => array(
            'notEmpty' => array(
                    'rule' => array('notEmpty'),
            ),
        ),
        'country' => array(
            'notEmpty' => array(
                    'rule' => array('notEmpty'),
            ),
        ),
        'email' => array(
            'email' => array(
                    'rule' => array('email'),
                    'allowEmpty' => false,
                    'required' => true
            ),
        ),
    );
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
    return true;
}
}
