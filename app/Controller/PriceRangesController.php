<?php
App::uses('AppController', 'Controller');
/**
 * PriceRanges Controller
 *
 * @property PriceRange $PriceRange
 * @property PaginatorComponent $Paginator
 */
class PriceRangesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public $paginate = array(
        'order' => array(
            'PriceRange.name' => 'asc'
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->PriceRange->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('priceRanges', $this->Paginator->paginate());
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->PriceRange->exists($id)) {
            throw new NotFoundException(__('Invalid price range'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->PriceRange->save($this->request->data)) {
                    $this->Session->setFlash(__('The price range has been saved.'), 'success', array('event' => 'saved.priceRange'));
                    return $this->redirect(array('action' => 'edit'));
            } else {
                    $this->Session->setFlash(__('The price range could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('PriceRange.' . $this->PriceRange->primaryKey => $id));
            $this->request->data = $this->PriceRange->find('first', $options);
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
            $this->PriceRange->id = $id;
            if (!$this->PriceRange->exists()) {
                    throw new NotFoundException(__('Invalid price range'));
            }
            $this->request->onlyAllow('post', 'delete');
            if ($this->PriceRange->delete()) {
                    $this->Session->setFlash(__('The price range has been deleted.'), 'success', array('event' => 'saved.priceRange'));
            } else {
                    $this->Session->setFlash(__('The price range could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'index'));
    }
    
    public function search() {
        $term = $this->request->query('term');
        if ($term)
        {
            $this->PriceRanges->recursive = 0;
            $this->Paginator->settings = $this->paginate;
            $this->set('priceRanges', $this->Paginator->paginate("PriceRange", array('PriceRange.Name LIKE' => '%' . $term . '%')));
        } else {
            $this->set('priceRanges', $this->Paginator->paginate());
        }
        $this->render('index');
    }
}
