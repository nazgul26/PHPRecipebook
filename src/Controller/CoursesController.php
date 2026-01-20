<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

class CoursesController extends AppController
{
    // Authentication required for all actions (default behavior in CakePHP 5)

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
            $course = $this->Courses->newEmptyEntity();
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
            $this->Flash->error(__('The course could not be saved. Please, try again.'));
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
