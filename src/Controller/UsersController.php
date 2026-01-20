<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Event\EventInterface;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Security;
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\Core\Configure;

class UsersController extends AppController
{
    use MailerAwareTrait;

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $allowPublicAccountCreation = env('ALLOW_PUBLIC_ACCOUNT_CREATION', false) == "true";

        if ($allowPublicAccountCreation) {
            $this->Authentication->allowUnauthenticated([
                'add',
                'reset',
                'resetLink',
                'login',
                'logout'
            ]);
        } else {
            $this->Authentication->allowUnauthenticated([
                'reset',
                'resetLink',
                'login',
                'logout'
            ]);
        }
    }

    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    public function isAuthorized($user): bool
    {
        $action = $this->request->getParam('action');
        if (in_array($action, array('index', 'view', 'delete'))) {
            if ($this->isAdmin) {
                return true;
            } else {
                $this->Flash->error(__('Not Admininstrator'));
                return false;
            }
        } else if ($action == "edit") {
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

    public function login()
    {
        $result = $this->Authentication->getResult();

        if ($this->request->is('post')) {
            if ($result && $result->isValid()) {
                // Check if account is locked
                $identity = $this->Authentication->getIdentity();
                $item = $this->Users->get($identity->get('id'));

                if ($item->locked) {
                    $this->Authentication->logout();
                    $this->Flash->error(__('Your account is currently locked. Use the password reset link to reset your password.'));
                    return;
                }

                // Set language preference
                if (!empty($item->language)) {
                    $session = $this->getRequest()->getSession();
                    $session->write('Config.language', $item->language);
                }

                // Update last login time
                $item->last_login = date('Y-m-d H:i:s');
                $this->Users->save($item);

                // Redirect to intended page or recipes index
                $target = $this->Authentication->getLoginRedirect() ?? ['controller' => 'Recipes', 'action' => 'index'];
                return $this->redirect($target);
            }
            if ($result && !$result->isValid()) {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        $this->Flash->success(__('Logged out.'));
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if ($data['password1'] === $data['password2']) {
                // only pass on the password to the Entity when there is a value (and it matches the confirm)
                if (!empty($data['password2'])) {
                    $data['password'] = (new DefaultPasswordHasher())->hash($data['password2']);
                }

                $data['access_level'] = Configure::read('AuthRoles.author');
                $data['country'] = 'us';

                $user = $this->Users->patchEntity($user, $data);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The account created. Login to continue.'));

                    return $this->redirect(['controller' => 'recipes', 'action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            } else {
                $this->Flash->error(__('Passwords did not match. Please, try again.'));
            }
        }

        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if ($data['password1'] === $data['password2']) {
                // only pass on the password to the Entity when there is a value (and it matches the confirm)
                if (!empty($data['password2'])) {
                    $data['password'] = (new DefaultPasswordHasher())->hash($data['password2']);
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

    public function reset()
    {
        if ($this->request->is('post')) {
            $emailAddress = $this->request->getData('email');
            $item = $this->Users->findByEmail($emailAddress)->first();
            if (isset($item)) {
                $hashedKey = hash('sha256', Text::uuid() . Security::getSalt());
                $item->reset_token = $hashedKey;
                $item->reset_time = date("Y-m-d H:i:s");

                if ($this->Users->save($item)) {
                    $resetLink = Router::url(['controller' => 'users', 'action' => 'resetLink'], true) . '/' . $hashedKey;
                    $this->getMailer('User')->send('resetPassword', [$item->toArray(), $resetLink]);

                    $this->Flash->success(__('Your reset email is on the way!'));
                    return;
                }
                $this->Flash->error(__('Could not send a reset email. Please contact support.'));
            }
            $this->Flash->error(__('Could not find your email address, try again.'));
        }
    }

    public function resetLink($token = null)
    {
        if ($token === null) {
            $this->Flash->error(__('Invalid reset link.'));
            return $this->redirect(['action' => 'login']);
        }

        $item = $this->Users->findByResetToken($token)->first();
        if (!$item) {
            $this->Flash->error(__('Invalid or expired reset link.'));
            return $this->redirect(['action' => 'login']);
        }

        // Check if token has expired (24 hours)
        $resetTime = strtotime($item->reset_time);
        if (time() - $resetTime > 86400) {
            $this->Flash->error(__('This reset link has expired. Please request a new one.'));
            return $this->redirect(['action' => 'reset']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if ($data['password1'] === $data['password2']) {
                if (!empty($data['password2'])) {
                    $item->password = (new DefaultPasswordHasher())->hash($data['password2']);
                    $item->reset_token = null;
                    $item->reset_time = null;
                    $item->locked = false;

                    if ($this->Users->save($item)) {
                        $this->Flash->success(__('Your password has been reset. Please login.'));
                        return $this->redirect(['action' => 'login']);
                    }
                    $this->Flash->error(__('Could not reset password. Please try again.'));
                }
            } else {
                $this->Flash->error(__('Passwords did not match. Please, try again.'));
            }
        }

        $this->set('user', $item);
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
