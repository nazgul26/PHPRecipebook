<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\Utility\Text;
use Cake\Routing\Router;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('String');
    }

    public function beforeFilter($event) {
        parent::beforeFilter($event);

        $this->Auth->allow([
            'reset', 
            'login',
            'logout']);
        
    }
    
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    public function isAuthorized($user) {

        $action = $this->request->getParam('action');
        if (in_array($action, array('index', 'view', 'delete'))) {
            if ($this->isAdmin) {
                return true;
            } else {
                $this->Flash->error(__('Not Admininstrator'));
                return false;
            }
        }
        else if ($action == "edit") {
            $passParam = $this->request->getParam('pass');
            if (isset($passParam[0]) && 
                    ($this->isAdmin || $passParam[0] == $user['id'])) {
                return true;
            } else {
                $this->Flash->error(__('Not allowed to edit another user.'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function login() {
        if ($this->request->is('post')) {
            $loginUserName = $this->request->getData('username');
            $item = $this->Users->findByUsername($loginUserName)->first();
            if ($item) {
                if ($item->locked) {
                    $this->Flash->error(__('Your account is currently locked. Use the password reset link to reset your password.'));
                    return;
                }
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    if (!empty($item->language)) {
                        $session = $this->getRequest()->getSession();
                        $session->write('Config.language', $item->language);
                    }

                    $item->last_login = date('Y-m-d H:i:s');
                    $this->Users->save($item);
                    
                    $redirectUrl = $this->Auth->redirectUrl();
                    if ($this->String->endsWith($redirectUrl, '/Users/login')) {
                        return $this->redirect(['controller' => 'recipes', 'action' => 'index']);
                    } else {
                        return $this->redirect($redirectUrl);
                    }
                }
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        $this->Flash->success(__('Logged out.'));
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if ($data['password1'] === $data['password2']) {
                // only pass on the password to the Entity when there is a value (and it matches the confirm)
                if (!empty($data['password2'])) {  
                    $data['password'] = (new DefaultPasswordHasher)->hash($data['password2']);
                }

                $user = $this->Users->patchEntity($user, $data);
                if ($this->Users->save($user)) {

                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            } else {
                $this->Flash->error(__('Passwords did not match. Please, try again.'));
            }
        }
        $this->set(compact('user'));
    }

    public function reset() {
        if ($this->request->is('post')) {
            $emailAddress = $this->request->getData('email');
            $item = $this->Users->findByEmail($emailAddress)->first();
            if (isset($item)) {
                $hashedKey = Security::hash(Text::uuid(),'sha1',true);
                $item->reset_token = $hashedKey;
                $item->reset_time = date("Y-m-d H:i:s");
                
                if ($this->Users->save($item))
                {
                    $Email = new Email('default');
                    $Email->from(array('passwordreset@phprecipebook.com' => 'PHP RecipeBook'))
                        ->template('reset', 'default')
                        ->emailFormat('both')
                        ->viewVars([
                            'firstName' => $item->name, 
                            'resetLink' => Router::url( ['controller'=>'users','action'=>'resetLink'], true ).'/'.$hashedKey])
                        ->to($emailAddress)
                        ->subject('PHPRecipebook Password Reset')
                        ->send();

                    $this->Flash->success(__('Your reset email is on the way!'), "success");
                    return;
                }
                $this->Flash->error(__('Could not send a reset email. Please contact support.'));
            }
            $this->Flash->error(__('Could not find your email address, try again.'));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
