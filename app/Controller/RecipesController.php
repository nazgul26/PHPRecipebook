<?php
App::uses('AppController', 'Controller');
/**
 * Recipes Controller
 *
 * @property Recipe $Recipe
 * @property PaginatorComponent $Paginator
 */
class RecipesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler');
    
    public $paginate = array(
        'order' => array(
            'Recipe.name' => 'asc'
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Recipe->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('recipes', $this->Paginator->paginate());
    }

    public function findByBase($baseId) {
        $this->Recipe->recursive = 0;
        $this->set('recipes', $this->Paginator->paginate('Recipe', array('Recipe.base_type_id' => $baseId)));
        $this->render('index');
    }

    public function findByCourse($courseId) {
        $this->Recipe->recursive = 0;
        $this->set('recipes', $this->Paginator->paginate('Recipe', array('Recipe.course_id' => $courseId)));
        $this->render('index');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Recipe->exists($id)) {
                throw new NotFoundException(__('Invalid recipe'));
        }
        $options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey => $id));
        $this->set('recipe', $this->Recipe->find('first', $options));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->Recipe->exists($id)) {
           throw new NotFoundException(__('Invalid recipe'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $recipe = $this->request->data;
            if ($this->Recipe->saveAll($this->request->data))
            {
                $this->Session->setFlash(__('The recipe has been saved.'), "success");
            } else {
                $this->Session->setFlash(__('The recipe could not be saved. Please, try again.'));
            }
        } else if ($id != null) {
            //NOTE: This is pretty cool, you can control the depth and properties with 'Containable' and contain.  
            //// much better then a loop of crazy custom SQL Code
            $this->Recipe->Behaviors->load('Containable');
            $options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey => $id), 
                'contain' => array('IngredientMapping.Ingredient.name', 'RelatedRecipe.Related.name'));
            $this->request->data = $this->Recipe->find('first', $options);
            $recipe = $this->request->data;
        }
        
        $ethnicities = $this->Recipe->Ethnicity->find('list');
        $baseTypes = $this->Recipe->BaseType->find('list');
        $courses = $this->Recipe->Course->find('list');
        $preparationTimes = $this->Recipe->PreparationTime->find('list');
        $difficulties = $this->Recipe->Difficulty->find('list');
        $sources = $this->Recipe->Source->find('list');
        $users = $this->Recipe->User->find('list');
        $preparationMethods = $this->Recipe->PreparationMethod->find('list');
        $units = $this->Recipe->IngredientMapping->Ingredient->Unit->find('list');
        $this->set(compact('ethnicities', 'baseTypes', 'courses', 'preparationTimes', 'difficulties', 'sources', 'users', 'preparationMethods', 'recipe', 'units'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Recipe->id = $id;
        if (!$this->Recipe->exists()) {
                throw new NotFoundException(__('Invalid recipe'));
        }
        if ($this->Recipe->delete()) {
                $this->Session->setFlash(__('The recipe has been deleted.'), "success");
        } else {
                $this->Session->setFlash(__('The recipe could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function search() {
        $term = $this->request->query('term');
        if ($term)
        {
            $this->Recipe->recursive = 0;
            $this->Paginator->settings = $this->paginate;
            $this->set('recipes', $this->Paginator->paginate("Recipe", array('Recipe.Name LIKE' => '%' . $term . '%')));
        } else {
            $this->set('recipes', $this->Paginator->paginate());
        }
        $this->render('index');
    }
    
    public function autoCompleteSearch() {
        $searchResults = array();
        $term = $this->request->query('term');
        if ($term)
        {
            $recipes = $this->Recipe->find('all', array(
              'conditions' => array('Recipe.name LIKE ' => '%' . trim($term) . '%')
            ));

            if (count($recipes) > 0) {
                foreach ($recipes as $item) {
                    $key = $item['Recipe']['name'];
                    $value = $item['Recipe']['id'];
                    array_push($searchResults, array("id"=>$value, "value" => strip_tags($key)));
                }
            } else {
                $key = "No Results for ' . $term . ' Found";
                array_push($searchResults, array("id"=>$value, "value" => ""));
            }

            $this->set(compact('searchResults'));
            $this->set('_serialize', 'searchResults');
        }
    }
}
