<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
    public $components = ['Paginator', 'String', 'Security'];

    public function beforeFilter()
    {
        parent::beforeFilter();
        if (Configure::read('App.allowPublicAccountCreation')) {
            $this->Auth->allow('add', 'logout', 'reset', 'resetLink');
        } else {
            $this->Auth->allow('logout', 'reset', 'resetLink');
        }

        // This pages index and view are little more restricted
        $this->Auth->deny('index', 'view', 'delete');
    }

    public function isAuthorized($user)
    {
        if (in_array($this->action, ['index', 'view', 'delete'])) {
            if ($this->isAdmin) {
                return true;
            } else {
                $this->Session->setFlash(__('Not Admininstrator'));

                return false;
            }
        } elseif ($this->action == 'edit') {
            if (isset($this->request->params['pass'][0]) &&
                    ($this->isAdmin || $this->request->params['pass'][0] == $user['id'])) {
                return true;
            } else {
                $this->Session->setFlash(__('Not allowed to edit another user.'));

                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $item = $this->User->findByUsername($this->data['User']['username']);
            if (isset($item['User'])) {
                if ($item['User']['locked']) {
                    $this->Session->setFlash(__('Your account is currently locked. Use the password reset link to reset your password.'));

                    return;
                } elseif ($this->Auth->login()) {
                    if (!empty($item['User']['language'])) {
                        $this->Session->write('Config.language', $item['User']['language']);
                    }

                    $redirectUrl = $this->Auth->redirectUrl();
                    if ($this->String->endsWith($redirectUrl, '/Users/login')) {
                        return $this->redirect(['controller' => 'recipes', 'action' => 'index']);
                    } else {
                        return $this->redirect($redirectUrl);
                    }
                }
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        $this->Session->setFlash(__('Logged out.'), 'success');

        return $this->redirect($this->Auth->logout());
    }

    public function reset()
    {
        App::uses('CakeEmail', 'Network/Email');

        if ($this->request->is('post')) {
            $item = $this->User->findByEmail($this->data['User']['email']);
            if (isset($item['User'])) {
                $hashedKey = Security::hash(String::uuid(), 'sha1', true);
                $item['User']['reset_token'] = $hashedKey;
                $item['User']['reset_time'] = date('Y-m-d H:i:s');

                if ($this->User->save($item)) {
                    $Email = new CakeEmail('default');
                    $Email->from(['passwordreset@phprecipebook.com' => 'PHP RecipeBook'])
                        ->template('reset', 'default')
                        ->emailFormat('both')
                        ->viewVars(['firstName' => $item['User']['name'], 'resetLink' => Router::url(['controller' => 'users', 'action' => 'resetLink'], true).'/'.$hashedKey])
                        ->to($this->data['User']['email'])
                        ->subject('PHPRecipebook Password Reset')
                        ->send();

                    $this->Session->setFlash(__('Your reset email is on the way!'), 'success');

                    return;
                }
                $this->Session->setFlash(__('Could not send a reset email. Please contact support.'));
            }
            $this->Session->setFlash(__('Could not find your email address, try again.'));
        }
    }

    public function resetLink($token)
    {
        if ($this->request->is('post')) {
            $token = $this->request->data['User']['token'];
            // Load the User from the Token. Don't trust the input.
            $user = $this->User->findByResetToken($token);

            // Set in case in case of failure and end of returning to user.
            $this->set(compact('user', 'token'));

            //$item['User']['reset_time']) -- TODO: need to compare time within 1 hour
            if ($this->data['User']['password1'] != $this->data['User']['password2']) {
                $this->Session->setFlash(__('Passwords are not set to same value. Please, try again.'));

                return;
            }

            // only pass on the password when there is a value (and it matches the confirm)
            if (empty($this->request->data['User']['password2'])) {
                $this->Session->setFlash(__('A new password is required. Please, try again.'));

                return;
            }

            // Everything looks good, lets reset :-)
            $user['User']['password'] = $this->request->data['User']['password2'];
            $user['User']['locked'] = false;
            $user['User']['reset_token'] = null;
            if ($this->User->save($user)) {
                $this->Session->setFlash(__('Password successfully reset. Login with your new password to continue.'), 'success');

                return $this->redirect(['controller' => 'users', 'action' => 'login']);
            } else {
                $this->Session->setFlash(__('The password could not be saved. Please, try again.'));

                return;
            }
        } else {
            $user = $this->User->findByResetToken($token);
            if (isset($user['User'])) {
                $this->set(compact('user', 'token'));

                return;
            }
        }
        $this->Session->setFlash(__('Could not find reset information. Please try again.'));
    }

    /**
     * index method.
     *
     * @return void
     */
    public function index()
    {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * view method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = ['conditions' => ['User.'.$this->User->primaryKey => $id]];
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method.
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->data['User']['password1'] === $this->data['User']['password2']) {
                // only pass on the password when there is a value (and it matches the confirm)
                if (!empty($this->request->data['User']['password2'])) {
                    $this->request->data['User']['password'] = $this->request->data['User']['password2'];
                }

                $this->request->data['User']['access_level'] = Configure::read('AuthRoles.author');
                $this->request->data['User']['country'] = 'us';

                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved.'), 'success');
                    $this->copyIngredientsFromAdmin();

                    return $this->redirect(['controller' => 'recipes', 'action' => 'edit']);
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                }
            } else {
                // didn't validate logic
                 $this->Session->setFlash(__('Passwords did not match. Please, try again.'));
            }
        }
    }

    private function copyIngredientsFromAdmin()
    {
        $this->loadModel('Ingredient');
        $newUserId = $this->User->getLastInsertID();
        $items = $this->Ingredient->find('all', ['conditions' => ['Ingredient.user_id' => '1']]);
        foreach ($items as $item) {
            $item['Ingredient']['id'] = null;
            $item['Ingredient']['user_id'] = $newUserId;
            $this->Ingredient->save($item);
        }
    }

    /**
     * edit method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is(['post', 'put'])) {
            if ($this->request->data['User']['password1'] === $this->request->data['User']['password2']) {
                // only pass on the password when there is a value (and it matches the confirm)
                if (!empty($this->request->data['User']['password2'])) {
                    $this->request->data['User']['password'] = $this->request->data['User']['password2'];
                }
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('Settings saved.  Logout/Sign In maybe required for settings to take effect.'), 'success');
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                }
            } else {
                // didn't validate logic
                 $this->Session->setFlash(__('Passwords did not match. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    /**
     * delete method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function delete($id = null)
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('The user has been deleted.'), 'success');
        } else {
            $this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
