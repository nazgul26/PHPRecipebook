<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 *
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReviewsController extends AppController
{
    public function isAuthorized($user) {
        // The owner of a review can edit and delete it
        $action = $this->request->getParam('action');
        $passParam = $this->request->getParam('pass');
        if (in_array($action, array('edit', 'delete')) && isset($passParam[1])) {
            $reviewId = (int) $passParam[1];

            if ($this->Users->isEditor($user) || $this->Reviews->isOwnedBy($reviewId, $user['id'])) {
                return true;
            }
            else {
                $this->Flash->error(__('Not Review Owner'));
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
    
        $this->paginate = [
            'contain' => ['Recipes', 'Users'],
        ];
        $reviews = $this->paginate($this->Reviews);

        $this->set(compact('reviews'));
    }

    public function view($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => ['Recipes', 'Users'],
        ]);

        $this->set('review', $review);
    }

    public function edit($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $recipes = $this->Reviews->Recipes->find('list', ['limit' => 200]);
        $users = $this->Reviews->Users->find('list', ['limit' => 200]);
        $this->set(compact('review', 'recipes', 'users'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $review = $this->Reviews->get($id);
        if ($this->Reviews->delete($review)) {
            $this->Flash->success(__('The review has been deleted.'));
        } else {
            $this->Flash->error(__('The review could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
