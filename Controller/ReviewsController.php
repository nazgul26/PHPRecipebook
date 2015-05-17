<?php
App::uses('AppController', 'Controller');

class ReviewsController extends AppController {


    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 8
    );
    
    public function isAuthorized($user) {
        // The owner of a review can edit and delete it
        if (in_array($this->action, array('edit', 'delete')) && isset($this->request->params['pass'][1])) {
            $reviewId = (int) $this->request->params['pass'][1];

            if ($this->User->isEditor($user) || $this->Review->isOwnedBy($reviewId, $user['id'])) {
                return true;
            }
            else {
                $this->Session->setFlash(__('Not Review Owner'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }
    
    public function index($recipeId = null) {
        if ($recipeId == null) {
            throw new NotFoundException(__('Missing review ID'));
        }
        $this->loadModel('Recipe');
        $this->Recipe->Behaviors->load('Containable');
        $options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey => $recipeId), 
                'contain' => array());
        $this->set('recipe', $this->Recipe->find('first', $options));
        $this->Review->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('reviews', $this->Paginator->paginate('Review', array('Review.recipe_id =' => $recipeId)));
        $this->set('recipeId', $recipeId);
    }


    public function view($id = null) {
        if (!$this->Review->exists($id)) {
            throw new NotFoundException(__('Invalid review'));
        }
        $options = array('conditions' => array('Review.' . $this->Review->primaryKey => $id));
        $this->set('review', $this->Review->find('first', $options));
    }


    public function edit($recipeId = null, $id = null) {
        if ($recipeId == null) {
            throw new NotFoundException(__('Missing recipe ID'));
        }
        
        if ($id != null && !$this->Review->exists($id)) {
                throw new NotFoundException(__('Invalid review'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Review']['user_id'] = $this->Auth->user('id');
            $this->request->data['Review']['recipe_id'] = $recipeId;
            try {
                if ($this->Review->save($this->request->data)) {
                    $this->Session->setFlash(__('The review has been saved.'), 'success');
                    return $this->redirect(array('action' => 'index', $recipeId));
                } else {
                    $this->Session->setFlash(__('The review could not be saved. Please, try again.'));
                }
            } catch (Exception $e) {
                $this->Session->setFlash(__('You have already entered a review for this recipe. Please edit or delete your existing review.'));
            }
        } else {
            $options = array('conditions' => array('Review.' . $this->Review->primaryKey => $id));
            $this->request->data = $this->Review->find('first', $options);
        }
        $recipe = $this->Review->Recipe->findById($recipeId);
        $this->set('recipe', $recipe);
    }

    public function delete($id = null) {
        $this->Review->id = $id;
        if (!$this->Review->exists()) {
                throw new NotFoundException(__('Invalid review'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Review->delete()) {
                $this->Session->setFlash(__('The review has been deleted.'));
        } else {
                $this->Session->setFlash(__('The review could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}
