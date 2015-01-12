<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout', 'reset', 'resetLink');
        
        // This pages index and view are little more restricted
        $this->Auth->deny('index', 'view');
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
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
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
                        ->to($this->data['User']['email'])
                        ->subject('PHPRecipebook Password Reset')
                        ->send('You have requested a password request, the hashed token is:' . $hashedKey);

                    $this->Session->setFlash(__('Your reset email is on the way!'), "success");
                    return;
                }
                $this->Session->setFlash(__('Could not send a reset email. Please contact support.'));
            }
            $this->Session->setFlash(__('Could not find your email address, try again.'));
        }
    }
    
    public function resetLink($token) {
        $item = $this->User->findByResetToken($token);
        //TODO: put $token in form to load user
        if (isset($item['User'])) {
            if ($this->request->is('post')) {
                //$item['User']['reset_time']) -- TODO: need to compare time within 1 hour
                $this->request->data['User']['locked'] = false;
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved.'), 'success');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The password could not be saved. Please, try again.'));
                }
            }
            return;
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
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved.'), 'success');
                    return $this->redirect(array('action' => 'index'));
            } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
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
