<?php

App::uses('AppController', 'Controller');
/**
 * PriceRanges Controller.
 *
 * @property PriceRange $PriceRange
 * @property PaginatorComponent $Paginator
 */
class PriceRangesController extends AppController
{
    public $components = ['Paginator'];

    public $paginate = [
        'order' => [
            'PriceRange.name' => 'asc',
        ],
    ];

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }

    /**
     * index method.
     *
     * @return void
     */
    public function index()
    {
        $this->PriceRange->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('priceRanges', $this->Paginator->paginate());
    }

    /**
     * edit method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function edit($id = null)
    {
        if ($id != null && !$this->PriceRange->exists($id)) {
            throw new NotFoundException(__('Invalid price range'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->PriceRange->save($this->request->data)) {
                $this->Session->setFlash(__('The price range has been saved.'), 'success', ['event' => 'saved.priceRange']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The price range could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['PriceRange.'.$this->PriceRange->primaryKey => $id]];
            $this->request->data = $this->PriceRange->find('first', $options);
        }
    }

    /**
     * delete method.
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function delete($id = null)
    {
        $this->PriceRange->id = $id;
        if (!$this->PriceRange->exists()) {
            throw new NotFoundException(__('Invalid price range'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->PriceRange->delete()) {
            $this->Session->setFlash(__('The price range has been deleted.'), 'success', ['event' => 'saved.priceRange']);
        } else {
            $this->Session->setFlash(__('The price range could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $term = $this->request->query('term');
        if ($term) {
            $this->PriceRanges->recursive = 0;
            $this->Paginator->settings = $this->paginate;
            $this->set('priceRanges', $this->Paginator->paginate('PriceRange', ['PriceRange.Name LIKE' => '%'.$term.'%']));
        } else {
            $this->set('priceRanges', $this->Paginator->paginate());
        }
        $this->render('index');
    }
}
