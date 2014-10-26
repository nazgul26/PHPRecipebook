<?php
App::uses('AppController', 'Controller');
/**
 * CoreIngredients Controller
 *
 * @property CoreIngredient $CoreIngredient
 * @property PaginatorComponent $Paginator
 */
class CoreIngredientsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler');
    public $paginate = array(
        'order' => array(
            'CoreIngredient.name' => 'asc'
        )
    );
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->CoreIngredient->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('coreIngredients', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->CoreIngredient->exists($id)) {
                throw new NotFoundException(__('Invalid core ingredient'));
        }
        $options = array('conditions' => array('CoreIngredient.' . $this->CoreIngredient->primaryKey => $id));
        $this->set('coreIngredient', $this->CoreIngredient->find('first', $options));
    }


    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->CoreIngredient->exists($id)) {
                throw new NotFoundException(__('Invalid core ingredient'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->CoreIngredient->save($this->request->data)) {
                $this->Session->setFlash(__('The core ingredient has been saved.'), 'success', array('event' => 'saved.coreIngredient'));
                return $this->redirect(array('action' => 'edit'));
            } else {
                $this->Session->setFlash(__('The core ingredient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CoreIngredient.' . $this->CoreIngredient->primaryKey => $id));
            $this->request->data = $this->CoreIngredient->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->CoreIngredient->id = $id;
        if (!$this->CoreIngredient->exists()) {
                throw new NotFoundException(__('Invalid core ingredient'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->CoreIngredient->delete()) {
                $this->Session->setFlash(__('The core ingredient has been deleted.'), 'success');
        } else {
                $this->Session->setFlash(__('The core ingredient could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    // Autocomplete Search
    public function search() {
        $searchResults = array();
        $term = $this->request->query('term');
        if ($term)
        {
            $coreIngredients = $this->CoreIngredient->find('all', array(
              'conditions' => array('CoreIngredient.name LIKE ' => '%' . trim($term) . '%')
            ));
            
            if (count($coreIngredients) > 0) {
                foreach ($coreIngredients as $item) {
                    $key = $item['CoreIngredient']['name'];
                    $value = $item['CoreIngredient']['groupNumber'];
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
