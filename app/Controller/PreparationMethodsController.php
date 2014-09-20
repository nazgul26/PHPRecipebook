<?php
App::uses('AppController', 'Controller');
/**
 * PreparationMethods Controller
 *
 * @property PreparationMethod $PreparationMethod
 * @property PaginatorComponent $Paginator
 */
class PreparationMethodsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->PreparationMethod->recursive = 0;
        $this->set('preparationMethods', $this->Paginator->paginate());
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if ($id != null && !$this->PreparationMethod->exists($id)) {
                throw new NotFoundException(__('Invalid preparation method'));
        }
        if ($this->request->is(array('post', 'put'))) {
                if ($this->PreparationMethod->save($this->request->data)) {
                        $this->Session->setFlash(__('The preparation method has been saved.'));
                        return $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The preparation method could not be saved. Please, try again.'));
                }
        } else {
                $options = array('conditions' => array('PreparationMethod.' . $this->PreparationMethod->primaryKey => $id));
                $this->request->data = $this->PreparationMethod->find('first', $options);
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
        $this->PreparationMethod->id = $id;
        if (!$this->PreparationMethod->exists()) {
                throw new NotFoundException(__('Invalid preparation method'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->PreparationMethod->delete()) {
                $this->Session->setFlash(__('The preparation method has been deleted.'));
        } else {
                $this->Session->setFlash(__('The preparation method could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}
