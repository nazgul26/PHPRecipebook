<?php
namespace App\Controller;

use App\Controller\AppController;

class CoursesController extends AppController
{
    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }

    public function index()
    {
        $courses = $this->paginate($this->Courses);

        $this->set(compact('courses'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Courses->exists($id)) {
            throw new NotFoundException(__('Invalid base type'));
        }

        if ($id == null) {
            $course = $this->Courses->newEntity();
        } else {
            $course = $this->Courses->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The course has been saved.'), 
                    ['params' => ['event' => 'saved.course']]);

                return $this->redirect(array('action' => 'edit'));
            }
            $this->Session->setFlash(__('The course could not be saved. Please, try again.'));
        }

        $this->set(compact('course')); 
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $course = $this->Courses->get($id);
        if ($this->Courses->delete($course)) {
            $this->Flash->success(__('The course has been deleted.'));
        } else {
            $this->Flash->error(__('The course could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
