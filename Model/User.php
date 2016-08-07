<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model.
 */
class User extends AppModel
{
    public $validate = [
        'username' => [
            'required' => [
                'rule'     => 'notBlank',
                'required' => true,
            ],
        ],
        // Turned off to allow Edit and not re-encrypt
        'password' => [
            'notEmpty' => [
                    'rule'     => ['notBlank'],
                    'required' => true,
                    'on'       => 'create',
            ],
        ],
        'name' => [
            'required' => [
                'rule' => 'notBlank',
            ],
        ],
        'access_level' => [
            'numeric' => [
                'rule'     => ['numeric', 'notBlank'],
                'required' => true,
            ],
        ],
        'language' => [
                'required' => [
                    'rule' => 'notBlank',
                ],
        ],
        'country' => [
                'required' => [
                    'rule' => 'notBlank',
                ],
        ],
        'email' => [
            'email' => [
                'rule'     => ['email', 'notBlank'],
                'required' => true,
            ],
        ],
    ];

    public function beforeSave($options = [])
    {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }

        return true;
    }

    public function isAdmin($user)
    {
        $adminRole = Configure::read('AuthRoles.admin');

        return $user['access_level'] >= $adminRole;
    }

    public function isEditor($user)
    {
        $editorRole = Configure::read('AuthRoles.editor');

        return $user['access_level'] >= $editorRole;
    }
}
