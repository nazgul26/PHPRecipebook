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
        $this->Auth->allow('add', 'logout', 'reset');
        
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
        if ($this->request->is('post')) {
            $item = $this->User->findByEmail($this->data['User']['email']);
            if (isset($item['User'])) {
                $key = String::uuid();
                $hashedKey = Security::hash(String::uuid(),'sha1',true); // goes in the email
                $item['User']['reset_token'] = $key;
                
                if ($this->User->save($item))
                {
                    $this->Session->setFlash(__('Your reset email is on the way!'), "success");
                    return;
                }
                $this->Session->setFlash(__('Could not send a reset email. Please contact support.'));
            }
            $this->Session->setFlash(__('Could not find your email address, try again.'));
        }
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
