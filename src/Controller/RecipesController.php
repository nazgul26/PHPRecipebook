<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\View\JsonView;
use App\Model\Entity\ShoppingList;

class RecipesController extends AppController
{
    // Filter to hide recipes of other users
    private $filterConditions = [];
    private $indexContains = ['Ethnicities', 'BaseTypes', 'Courses', 'PreparationTimes', 'Difficulties', 'Sources', 'Users', 'PreparationMethods'];

    public function initialize(): void
    {
        parent::initialize();
        // Removed on CakePHP 5 upgrade
        // $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        if (!$this->isPrivateCollection) {
            $this->Authentication->allowUnauthenticated([
                'findByBase',
                'findByCourse',
                'findByPrepMethod',
                'search',
                'autoCompleteSearch',
                'index',
                'view',
                'display'
            ]);
        }

        //TODO: make this a setting to filter out mine (probably remember last login to get ID)
        //$this->filterConditions = array('Recipe.user_id' => $this->Authentication->getIdentity()?->get('id'));
        $this->filterConditions = [];
    }

    public function isAuthorized($user): bool
    {
        // The owner of a recipe can edit and delete it
        $action = $this->request->getParam('action');
        $passParam = $this->request->getParam('pass');
        if (in_array($action, array('edit', 'delete')) && isset($passParam[0])) {
            $recipeId = (int) $passParam[0];
            $usersTable = $this->fetchTable('Users');
            if ($usersTable->isEditor($user) || $this->Recipes->isOwnedBy($recipeId, $user['id'])) {
                return true;
            } else {
                $this->Flash->error(__('Not Recipe Owner'));
                return false;
            }
        }

        // Just in case the base controller has something to add
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $query = $this->Recipes->find()
            ->contain($this->indexContains)
            ->where($this->filterConditions);
        $recipes = $this->paginate($query);

        $this->set(compact('recipes'));
    }

    public function view($id = null, $servings = null)
    {
        $recipe = $this->Recipes->get($id, contain: [
            'Ethnicities',
            'BaseTypes',
            'Courses',
            'PreparationTimes',
            'Difficulties',
            'Sources',
            'Users' => [
                'fields' => ['name', 'id']
            ],
            'PreparationMethods',
            'Attachments',
            'IngredientMappings' => [
                'Ingredients' => [
                    'fields' => ['name']
                ],
                'Units' => [
                    'fields' => ['name', 'abbreviation']
                ],
                'sort' => ['IngredientMappings.sort_order' => 'ASC']
            ],
            'RelatedRecipes' => [
                'Recipes' => [
                    'fields' => ['id', 'name', 'directions'],
                        'IngredientMappings' => [
                            'Ingredients' => [
                                'fields' => ['name']
                            ],
                            'Units' => [
                                'fields' => ['name', 'abbreviation']
                            ],
                            'sort' => ['IngredientMappings.sort_order' => 'ASC']
                    ]
                ]
            ],
            'Reviews',
            'Tags'
        ]);

        // Keep Private recipes Private
        $identity = $this->Authentication->getIdentity();
        $user = $identity ? $identity->getOriginalData()->toArray() : null;
        $usersTable = $this->fetchTable('Users');
        if (!$usersTable->isEditor($user) && $recipe->private == 'true' && $recipe->user->id != $identity?->get('id')) {
            throw new UnauthorizedException(__('Recipe is private and you are not the owner.'));
        }

        $this->set('recipe', $recipe);
        $this->set('servings', $servings);
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Recipes->exists($id)) {
            throw new NotFoundException(__('Invalid price range'));
        }

        if ($id == null) {
            $recipe = $this->Recipes->newEmptyEntity();
        } else {
            $recipe = $this->Recipes->get($id, contain: [
                'Ethnicities',
                'BaseTypes',
                'Courses',
                'PreparationTimes',
                'Difficulties',
                'Sources',
                'Users' => [
                    'fields' => ['name', 'id']
                ],
                'PreparationMethods',
                'Attachments',
                'IngredientMappings' => [
                    'Ingredients' => [
                        'fields' => ['name']
                    ],
                    'Units' => [
                        'fields' => ['name', 'abbreviation']
                    ],
                    'sort' => ['IngredientMappings.sort_order' => 'ASC']
                ],
                'RelatedRecipes' => [
                    'Recipes' => [
                        'fields' => ['id', 'name', 'directions'],
                            'IngredientMappings' => [
                                'Ingredients' => [
                                    'fields' => ['name']
                            ],
                            'Units' => [
                                'fields' => ['name', 'abbreviation']
                            ],
                            'sort' => ['IngredientMappings.sort_order' => 'ASC']
                        ]
                    ]
                ],
                'Reviews',
                'Tags'
            ]);
        }

        if (!$this->request->is(['patch', 'post', 'put'])) {
            $recipe->tags_list = $this->formatTagsList($recipe->tags ?? []);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $recipe = $this->Recipes->patchEntity($recipe, $this->request->getData());

            //TODO: Keep the original author just in case editor/admin edits
            $userId = (int) $this->Authentication->getIdentity()?->get('id');
            $recipe->user_id = $userId;
            $recipe->tags = $this->buildTagEntities($this->request->getData('tags_list'), $userId);
            if ($this->Recipes->save($recipe)) {
                $this->Flash->success(__('The recipe has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
            }

            //NOTE: Helpful debug info
            /*$x = $recipe->getErrors();
            if ($x) {
                debug($recipe);
                debug($x);
                return false;
            }*/
        }
        $ethnicities = $this->Recipes->Ethnicities->find('list', limit: 200)->orderBy(['Ethnicities.name' => 'ASC']);
        $baseTypes = $this->Recipes->BaseTypes->find('list', limit: 200)->orderBy(['BaseTypes.name' => 'ASC']);
        $courses = $this->Recipes->Courses->find('list', limit: 200)->orderBy(['Courses.name' => 'ASC']);
        $preparationTimes = $this->Recipes->PreparationTimes->find('list', limit: 200)->orderBy(['PreparationTimes.name' => 'ASC']);
        $difficulties = $this->Recipes->Difficulties->find('list', limit: 200);
        $sources = $this->Recipes->Sources->find('list', limit: 200)->orderBy(['Sources.name' => 'ASC']);
        $users = $this->Recipes->Users->find('list', limit: 200)->orderBy(['Users.name' => 'ASC']);
        $preparationMethods = $this->Recipes->PreparationMethods->find('list', limit: 200)->orderBy(['PreparationMethods.name' => 'ASC']);
        $units = $this->Recipes->IngredientMappings->Units->find('list', limit: 200)->orderBy(['Units.name' => 'ASC']);
        $this->set(compact('recipe', 'ethnicities', 'baseTypes', 'courses', 'preparationTimes', 'difficulties', 'sources', 'users', 'preparationMethods', 'units'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recipe = $this->Recipes->get($id);
        if ($this->Recipes->delete($recipe)) {
            $this->Flash->success(__('The recipe has been deleted.'));
        } else {
            $this->Flash->error(__('The recipe could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function removeIngredientMapping($recipeId, $mappingId)
    {
        $entity = $this->Recipes->IngredientMappings->get($mappingId);
        if ($this->Recipes->IngredientMappings->delete($entity)) {
            $this->Flash->success(__('The ingredient has been removed.'));
        } else {
            $this->Flash->error(__('The ingredient could not be removed. Please, try again.'));
        }
    }

    public function deleteAttachment($recipeId, $id)
    {
        $image = $this->Recipes->Attachments->get($id);
        if ($this->Recipes->Attachments->delete($image)) {
            $this->Flash->success(__('The image has been removed.'));
        } else {
            $this->Flash->error(__('The image could not be removed. Please, try again.'));
        }
        return $this->redirect(array('action' => 'edit', $recipeId));
    }

    public function findByBase($baseId)
    {
        $this->filterConditions['Recipes.base_type_id'] = $baseId;
        $query = $this->Recipes->find()
            ->contain($this->indexContains)
            ->where($this->filterConditions);
        $recipes = $this->paginate($query);

        $this->set(compact('recipes'));
        $this->render('index');
    }

    public function findByCourse($courseId)
    {
        $this->filterConditions['Recipes.course_id'] = $courseId;
        $query = $this->Recipes->find()
            ->contain($this->indexContains)
            ->where($this->filterConditions);
        $recipes = $this->paginate($query);

        $this->set(compact('recipes'));
        $this->render('index');
    }

    public function findByPrepMethod($methodId)
    {
        $this->filterConditions['Recipes.preparation_method_id'] = $methodId;
        $query = $this->Recipes->find()
            ->contain($this->indexContains)
            ->where($this->filterConditions);
        $recipes = $this->paginate($query);

        $this->set(compact('recipes'));
        $this->render('index');
    }

    public function search()
    {
        $term = $this->request->getQuery('term');
        if ($term) {
            $conditions = array_merge($this->filterConditions, ['LOWER(Recipes.name) LIKE' => '%' . trim(strtolower($term)) . '%']);
            $query = $this->Recipes->find()
                ->contain($this->indexContains)
                ->where($conditions);
        } else {
            $query = $this->Recipes->find()
                ->where($this->filterConditions);
        }
        $recipes = $this->paginate($query);
        $this->set(compact('recipes'));
        $this->render('index');
    }

    private function normalizeTagNames(?string $tagList): array
    {
        if ($tagList === null) {
            return [];
        }

        $parts = preg_split('/[,\n;]/', $tagList);
        $unique = [];

        foreach ($parts as $part) {
            $name = trim($part);
            if ($name === '') {
                continue;
            }

            $key = strtolower($name);
            if (!isset($unique[$key])) {
                $unique[$key] = $name;
            }
        }

        return array_values($unique);
    }

    private function buildTagEntities(?string $tagList, int $userId): array
    {
        $tagNames = $this->normalizeTagNames($tagList);
        if (empty($tagNames) || $userId === 0) {
            return [];
        }

        $tagsTable = $this->fetchTable('Tags');
        $lowerNames = array_map('strtolower', $tagNames);

        $existingTags = $tagsTable->find()
            ->where([
                'Tags.user_id' => $userId,
                'LOWER(Tags.name) IN' => $lowerNames,
            ])
            ->all();

        $existingByKey = [];
        foreach ($existingTags as $tag) {
            $existingByKey[strtolower($tag->name)] = $tag;
        }

        $tagEntities = [];
        foreach ($tagNames as $name) {
            $key = strtolower($name);
            if (isset($existingByKey[$key])) {
                $tagEntities[] = $existingByKey[$key];
                continue;
            }

            $tagEntities[] = $tagsTable->newEntity([
                'name' => $name,
                'user_id' => $userId,
            ]);
        }

        return $tagEntities;
    }

    private function formatTagsList(array $tags): string
    {
        $names = [];
        foreach ($tags as $tag) {
            if (!empty($tag->name)) {
                $names[] = $tag->name;
            }
        }

        return implode(', ', $names);
    }


    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function autoCompleteSearch()
    {
        $this->request = $this->request->withHeader('Accept', 'application/json');

        $searchResults = [];
        $term = $this->request->getQuery('term');
        if ($term) {
            $recipes = $this->Recipes->find()
                ->select(['Recipes.id', 'Recipes.name', 'Recipes.serving_size'])
                ->where(array_merge($this->filterConditions, ['LOWER(Recipes.name) LIKE ' => '%' . trim(strtolower($term)) . '%']));

            if ($recipes->count() > 0) {
                foreach ($recipes as $item) {
                    $key = $item->name;
                    $value = $item->id;
                    $servings = $item->serving_size;
                    array_push($searchResults, array('id' => $value, 'value' => strip_tags($key), 'servings' => $servings));
                }
            } else {
                $key = "No Results for '$term' Found";
                array_push($searchResults, array('id' => '', 'value' => $key, 'servings' => '0'));
            }

            $this->set(compact('searchResults'));
            $this->viewBuilder()->setOption('serialize', 'searchResults');
        }
    }

    public function contains()
    {
        //$this->fetchTable('IngredientMappings');
        $shoppingList = new ShoppingList();
        if ($this->request->is(array('post', 'put'))) {
            $ingredients = $this->request->getData();
            $filter = [];
            foreach ($ingredients["data"] as $ingredientId) {
                array_push($filter, ['IngredientMappings.ingredient_id' => $ingredientId]);
            }
            $query = $this->Recipes->find()
                ->select([
                'id',
                'name',
                'matches' => "count(*)"])
                ->innerJoinWith('IngredientMappings')
            ->where(['OR' => $filter])
            ->groupBy(['Recipes.id', 'Recipes.name'])
            ->orderBy(["matches" => "DESC"])
            ->limit(20);

            $recipes = $query->toArray();

            $this->set(compact('recipes', 'shoppingList'));
            return;
        }
        $this->set(compact('shoppingList'));
    }
}
