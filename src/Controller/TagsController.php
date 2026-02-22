<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\View\JsonView;

class TagsController extends AppController
{
    public $filterConditions = array();

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $this->filterConditions = array('Tags.user_id' => $this->Authentication->getIdentity()?->get('id'));
    }

    public function isAuthorized($user): bool
    {
        $action = $this->request->getParam('action');
        $passParam = $this->request->getParam('pass');
        if (in_array($action, array('edit', 'delete')) && isset($passParam[0])) {
            $tagId = (int) $passParam[0];
            $usersTable = $this->fetchTable('Users');
            if ($usersTable->isEditor($user) || $this->Tags->isOwnedBy($tagId, $user['id'])) {
                return true;
            } else {
                $this->Flash->error(__('Not Tag Owner'));
                return false;
            }
        }

        return parent::isAuthorized($user);
    }

    public function index()
    {
        $query = $this->Tags->find()
            ->where($this->filterConditions)
            ->orderBy(['Tags.name' => 'ASC']);
        $tags = $this->paginate($query);
        $this->set(compact('tags'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Tags->exists($id)) {
            throw new NotFoundException(__('Invalid tag'));
        }

        if ($id == null) {
            $tag = $this->Tags->newEmptyEntity();
        } else {
            $tag = $this->Tags->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            $tag->user_id = $this->Authentication->getIdentity()?->get('id');

            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'),
                    ['params' => ['event' => 'saved.tag']]);

                return $this->redirect(array('action' => 'edit'));
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $this->set(compact('tag'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag has been deleted.'));
        } else {
            $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $term = $this->request->getQuery('term');
        $conditions = [];
        if ($term) {
            $conditions = array_merge($this->filterConditions, array('LOWER(Tags.name) LIKE' => '%' . trim(strtolower($term)) . '%'));
        } else {
            $conditions = $this->filterConditions;
        }

        $query = $this->Tags->find()
            ->where($conditions)
            ->orderBy(['Tags.name' => 'ASC']);
        $tags = $this->paginate($query);
        $this->set(compact('tags'));
        $this->render('index');
    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function autoCompleteSearch()
    {
        $this->request = $this->request->withHeader('Accept', 'application/json');

        $searchResults = [];
        $conditions = [];

        $term = $this->request->getQuery('term');
        if ($term) {
            $conditions = array_merge($this->filterConditions, array('LOWER(Tags.name) LIKE' => '%' . trim(strtolower($term)) . '%'));
        } else {
            $conditions = $this->filterConditions;
        }

        $tags = $this->Tags->find()->where($conditions)->orderBy(['Tags.name' => 'ASC']);

        $exactMatch = false;
        if ($tags->count() > 0) {
            foreach ($tags as $item) {
                $key = $item->name;
                $value = $item->id;
                array_push($searchResults, array('id' => $value, 'value' => strip_tags($key)));
                if (strtolower(trim($key)) === strtolower(trim($term))) {
                    $exactMatch = true;
                }
            }
        }
        if ($term && !$exactMatch) {
            array_push($searchResults, array('id' => '', 'value' => __('Create: ') . strip_tags($term), 'create' => strip_tags(trim($term))));
        }

        $this->set(compact('searchResults'));
        $this->viewBuilder()->setOption('serialize', 'searchResults');
    }
}
