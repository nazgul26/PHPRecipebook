<?php

App::uses('AppController', 'Controller');
/**
 * Courses Controller.
 *
 * @property Course $Course
 * @property PaginatorComponent $Paginator
 */
class CoursesController extends AppController
{
    public $components = ['Paginator'];

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
        $this->Course->recursive = 0;
        $this->set('courses', $this->Paginator->paginate());
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
        if ($id != null && !$this->Course->exists($id)) {
            throw new NotFoundException(__('Invalid course'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Course->save($this->request->data)) {
                $this->Session->setFlash(__('The course has been saved.'), 'success', ['event' => 'saved.course']);

                return $this->redirect(['action' => 'edit']);
            } else {
                $this->Session->setFlash(__('The course could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Course.'.$this->Course->primaryKey => $id]];
            $this->request->data = $this->Course->find('first', $options);
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
        $this->Course->id = $id;
        if (!$this->Course->exists()) {
            throw new NotFoundException(__('Invalid course'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Course->delete()) {
            $this->Session->setFlash(__('The course has been deleted.'), 'success', ['event' => 'saved.course']);
        } else {
            $this->Session->setFlash(__('The course could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
