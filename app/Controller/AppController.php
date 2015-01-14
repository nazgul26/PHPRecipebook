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
            )
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->authError = __('Enter your login information to continue.');
        
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax'; 
        } else {
            $this->layout = 'default';
        }
        
        $this->Auth->allow('index', 'view', 'display');
        
        // Let everyone know about the user
        $this->set('loggedIn', $this->Auth->loggedIn());
    }
    
}
