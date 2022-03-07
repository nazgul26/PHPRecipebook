<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginRedirect' => [
                'controller' => 'recipes',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    public function beforeFilter(Event $event) {
        $this->loadModel('Users');
        
        parent::beforeFilter($event);
        
        // Delete the default auth message.  Just show them the login page
        //  people will get the idea pretty quickly.
        $session = $this->getRequest()->getSession();
        $session->delete('Message.auth');

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax'; 
        }
        
        // Let everyone know about the user
        $user = $this->Auth->user();
        $this->set('loggedIn', $user != null);
        $this->isAdmin = $this->Users->isAdmin($user);
        $this->isEditor = $this->Users->isEditor($user);
        $this->isPrivateCollection = env('PRIVATE_COLLECTION', false) == "true";
        $this->set('loggedInuserId', $this->Auth->user('id'));
        $this->set('isAdmin', $this->isAdmin);
        $this->set('isEditor', $this->isEditor);
        $this->set('allowAccountCreation', env('ALLOW_PUBLIC_ACCOUNT_CREATION', false) == "true");
    }

    public function isAuthorized($user) {
        $this->loadModel('Users');
        $controllerName = $this->request->getParam('controller');

        // Check Auth for Admin only Pages.
        if (in_array($controllerName, array(
            'BaseTypes', 
            'Courses', 
            'Difficulties', 
            'Ethnicities', 
            'Locations', 
            'PreparationMethods',
            'PreparationTimes',
            'PriceRanges',
            'Settings',
            'Stores',
            'Units',
            'Vendors'))) {
            
            if ($this->Users->isAdmin($user)) { 
                return true;
            }
            $this->Flash->error(__('Not Authorized.'));
            return false;
        }
        return true; // expected to be overriden
    }
}
