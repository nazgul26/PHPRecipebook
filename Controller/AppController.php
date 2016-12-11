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

    public $isAdmin = false;
    
    public $components = array(
        'Session',
        'RequestHandler',
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
        $this->loadModel('User');
        
        parent::beforeFilter();
        
        // Disable content cache for Chrome
        $this->response->disableCache();
        
        // Delete the default auth message.  Just show them the login page
        //  people will get the idea pretty quickly.
        $this->Session->delete('Message.auth');

        /*if ($this->RequestHandler->isMobile()) {
            $this->layout = 'mobile';
            $this->isMobile = true;
        } else {
            $this->layout = 'mobile';
            $this->isMobile = true;
        }*/
        
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax'; 
        }
        
        if (Configure::read('App.privateCollection')) {
            $this->Auth->deny();   
        } else {
            $this->Auth->allow('index', 'view', 'display');
        }
        
        
        // Let everyone know about the user
        $this->set('loggedIn', $this->Auth->loggedIn());
        $user = $this->Auth->user();
        $this->isAdmin = $this->User->isAdmin($user);
        $this->isEditor = $this->User->isEditor($user);
        $this->set('loggedInuserId', $this->Auth->user('id'));
        $this->set('isAdmin', $this->isAdmin);
        $this->set('isEditor', $this->isEditor);
        $this->set('allowAccountCreation', Configure::read('App.allowPublicAccountCreation'));
    }
    
    public function isAuthorized($user) {
        $this->loadModel('User');
        
        // Check Auth for Admin only Pages.
        if (in_array($this->params['controller'], array(
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
            
            if ($this->User->isAdmin($user)) { 
                return true;
            }
            $this->Session->setFlash(__('Not Authorized.'));
            return false;
        }
        return true; // expected to be overriden
    }
}
