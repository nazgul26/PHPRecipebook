<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $components = array('Paginator', 'String');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout', 'reset', 'resetLink');
        
        // This pages index and view are little more restricted
        $this->Auth->deny('index', 'view', 'delete');
    }
    
    public function isAuthorized($user) {
        if (in_array($this->action, array('index', 'view', 'delete'))) {

            if ($this->User->isAdmin($user)) {
                return true;
            } else {
                $this->Session->setFlash(__('Not Admininstrator'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }
    
    public function login() {
        if ($this->request->is('post')) {
            $item = $this->User->findByUsername($this->data['User']['username']);
            if (isset($item['User'])) {
                if ($item['User']['locked']) {
                    $this->Session->setFlash(__('Your account is currently locked. Use the password reset link to reset your password.'));
                    return;
                }
                else if ($this->Auth->login()) {
                    //echo "redirect to:" . $this->Auth->redirectUrl();
                    $redirectUrl = $this->Auth->redirectUrl();
                    if ($this->String->endsWith($redirectUrl, '/Users/login')) {
                        return $this->redirect(array('controller' => 'recipes', 'action' => 'index'));
                    } else {
                        return $this->redirect($redirectUrl);
                    }
                }
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        $this->Session->setFlash(__('Logged out.'), "success");
        return $this->redirect($this->Auth->logout());
    }
    
    public function reset() {
        App::uses('CakeEmail', 'Network/Email');
               
        if ($this->request->is('post')) {
            $item = $this->User->findByEmail($this->data['User']['email']);
            if (isset($item['User'])) {
                $hashedKey = Security::hash(String::uuid(),'sha1',true);
                $item['User']['reset_token'] = $hashedKey;
                $item['User']['reset_time'] = date("Y-m-d H:i:s");
                
                if ($this->User->save($item))
                {
                    $Email = new CakeEmail('default');
                    $Email->from(array('passwordreset@phprecipebook.com' => 'PHP RecipeBook'))
                        ->template('reset', 'default')
                        ->emailFormat('both')
                        ->viewVars(array('firstName' => $item['User']['name'], 'resetLink' => 
                            Router::url( array('controller'=>'users','action'=>'resetLink'), true ).'/'.$hashedKey))
                        ->to($this->data['User']['email'])
                        ->subject('PHPRecipebook Password Reset')
                        ->send();

                    $this->Session->setFlash(__('Your reset email is on the way!'), "success");
                    return;
                }
                $this->Session->setFlash(__('Could not send a reset email. Please contact support.'));
            }
            $this->Session->setFlash(__('Could not find your email address, try again.'));
        }
    }
    
    public function resetLink($token) {
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
                return $this->redirect(array('controller' => 'users', 'action' => 'login'));
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
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            if ($this->data['User']['password1'] === $this->data['User']['password2']) {
                // only pass on the password when there is a value (and it matches the confirm)
                if (!empty($this->request->data['User']['password2'])) {  
                    $this->request->data['User']['password'] = $this->request->data['User']['password2'];
                }
                
                $this->request->data['User']['access_level'] = Configure::read('AuthRoles.author');
                $this->request->data['User']['language'] = 'en';
                $this->request->data['User']['country'] = 'us';
                
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved.'), 'success');
                    return $this->redirect(array('controller'=> 'recipes', 'action' => 'edit'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                }
            } else {
                // didn't validate logic
                 $this->Session->setFlash(__('Passwords did not match. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->User->exists($id)) {
                throw new NotFoundException(__('Invalid user'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->data['User']['password1'] === $this->data['User']['password2']) {
                // only pass on the password when there is a value (and it matches the confirm)
                if (!empty($this->request->data['User']['password2'])) {  
                    $this->request->data['User']['password'] = $this->request->data['User']['password2'];
                }
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved.'), 'success');
                    return $this->redirect(array('action' => 'index'));
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
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
                $this->Session->setFlash(__('The user has been deleted.'));
        } else {
                $this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }   
 }
