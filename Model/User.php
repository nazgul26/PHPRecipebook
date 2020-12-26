<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 */
class User extends AppModel {

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => 'notBlank',
                'required' => true
            )
        ),
        // Turned off to allow Edit and not re-encrypt
        'password' => array(
            'notEmpty' => array(
                    'rule' => array('notBlank'),
                    'required' => true,
                    'on' => 'create'
            ),
        ),
        'name' => array(
            'required' => array(
                'rule' => 'notBlank'
            )
        ),
        'access_level' => array(
            'numeric' => array(
                'rule' => array('numeric', 'notBlank'),
                'required' => true
            ),
        ),
        'language' => array(
                'required' => array(
                    'rule' => 'notBlank'
                )
        ),
        'country' => array(
                'required' => array(
                    'rule' => 'notBlank'
                )
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email', 'notBlank'),
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
    
    public function isAdmin($user) {
        $adminRole = Configure::read('AuthRoles.admin');
        if ((isset($user['access_level']) && $user['access_level'] >= $adminRole)) {
          return $user['access_level'] >= $adminRole;
        }
    }
    
    public function isEditor($user) {
        $editorRole = Configure::read('AuthRoles.editor');
        if ((isset($user['access_level']) && $user['access_level'] >= $editorRole)) {
          return $user['access_level'] >= $editorRole;
        }
    }
}
