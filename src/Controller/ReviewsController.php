<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 *
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReviewsController extends AppController
{
    public function isAuthorized($user): bool
    {
        // The owner of a review can edit and delete it
        $action = $this->request->getParam('action');
        $passParam = $this->request->getParam('pass');
        if (in_array($action, array('edit', 'delete')) && isset($passParam[1])) {
            $reviewId = (int) $passParam[1];
            $usersTable = $this->fetchTable('Users');
            if ($usersTable->isEditor($user) || $this->Reviews->isOwnedBy($reviewId, $user['id'])) {
                return true;
            } else {
                $this->Flash->error(__('Not Review Owner'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function index($recipeId = null)
    {
        if ($recipeId == null) {
            throw new NotFoundException(__('Missing review ID'));
        }

        $recipesTable = $this->fetchTable('Recipes');
        $recipe = $recipesTable->get($recipeId);

        $query = $this->Reviews->find()
            ->contain(['Recipes', 'Users'])
            ->where(['Reviews.recipe_id =' => $recipeId]);
        $reviews = $this->paginate($query);

        $this->set(compact('recipe', 'reviews', 'recipeId'));
    }

    public function view($id = null)
    {
        $review = $this->Reviews->get($id, contain: ['Recipes', 'Users']);

        $this->set('review', $review);
    }

    public function edit($recipeId = null, $id = null)
    {
        if ($recipeId == null) {
            throw new NotFoundException(__('Missing recipe ID'));
        }
        if ($id != null && !$this->Reviews->exists($id)) {
            throw new NotFoundException(__('Invalid review'));
        }

        $recipesTable = $this->fetchTable('Recipes');
        $recipe = $recipesTable->get($recipeId);

        if ($id == null) {
            $review = $this->Reviews->newEmptyEntity();
        } else {
            $review = $this->Reviews->get($id, contain: [
                'Users' => [
                    'fields' => ['name', 'id']
                ]
            ]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            $review->recipe_id = $recipeId;
            $review->user_id = $this->Authentication->getIdentity()?->get('id');
            try {
                if ($this->Reviews->save($review)) {
                    $this->Flash->success(__('The review has been saved.'));

                    return $this->redirect(['action' => 'index', $recipeId]);
                }
                $this->Flash->error(__('The review could not be saved. Please, try again.'));
            } catch (\Exception $e) {
                $this->Flash->error(__('You have already entered a review for this recipe. Please edit or delete your existing review.'));
            }
        }

        $this->set(compact('recipe', 'recipeId', 'review'));
    }

    public function delete($recipeId = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $review = $this->Reviews->get($id);
        if ($this->Reviews->delete($review)) {
            $this->Flash->success(__('The review has been deleted.'));
        } else {
            $this->Flash->error(__('The review could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', $recipeId]);
    }
}
