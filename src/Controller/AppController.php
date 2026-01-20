<?php
declare(strict_types=1);

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
use Cake\Event\EventInterface;
use function Cake\Core\env;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * @var bool
     */
    public $isAdmin = false;

    /**
     * @var bool
     */
    public $isEditor = false;

    /**
     * @var bool
     */
    public $isPrivateCollection = false;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        //$this->loadComponent('RequestHandler', [
        //    'enableBeforeRedirect' => false,
        //]);
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Delete the default auth message.  Just show them the login page
        //  people will get the idea pretty quickly.
        $session = $this->getRequest()->getSession();
        $session->delete('Message.auth');

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        }

        // Let everyone know about the user
        $identity = $this->Authentication->getIdentity();
        $user = $identity ? $identity->getOriginalData()->toArray() : null;

        $usersTable = $this->fetchTable('Users');
        $this->set('loggedIn', $user !== null);
        $this->isAdmin = $usersTable->isAdmin($user);
        $this->isEditor = $usersTable->isEditor($user);
        $this->isPrivateCollection = env('PRIVATE_COLLECTION', false) == "true";
        $this->set('loggedInuserId', $identity?->get('id'));
        $this->set('isAdmin', $this->isAdmin);
        $this->set('isEditor', $this->isEditor);
        $this->set('allowAccountCreation', env('ALLOW_PUBLIC_ACCOUNT_CREATION', false) == "true");
    }

    public function isAuthorized($user): bool
    {
        $usersTable = $this->fetchTable('Users');
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

            if ($usersTable->isAdmin($user)) {
                return true;
            }
            $this->Flash->error(__('Not Authorized.'));
            return false;
        }
        return true; // expected to be overriden
    }
}
