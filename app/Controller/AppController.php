<?php

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'recipes',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'recipes',
                'action' => 'index'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            ),
            'authorize' => array('Controller') // Added this line
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        
        // Delete the default auth message.  Just show them the login page
        //  people will get the idea pretty quickly.
        $this->Session->delete('Message.auth');
        
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax'; 
        } else {
            $this->layout = 'default';
        }
        
        $this->Auth->allow('index', 'view', 'display');
        
        // Let everyone know about the user
        $this->set('loggedIn', $this->Auth->loggedIn());
    }
    
    public function isAuthorized($user) {
        // Check Auth for Admin only Pages.
        if (in_array($this->params['controller'], array(
            'BaseTypes', 
            'CoreIngredients', 
            'Courses', 
            'Difficulties', 
            'Ethnicities', 
            'Locations', 
            'PreparationMethods',
            'PreparationTimes',
            'PriceRanges',
            'Settings',
            'Stores',
            'Units'))) {
            $adminRole = Configure::read('AuthRoles.admin');
            if ($user['access_level'] >= $adminRole) 
            { 
                return true;
            }
            $this->Session->setFlash(__('Not Authorized.'));
            return false;
        }
        return true; // expected to be overriden
    }
}
