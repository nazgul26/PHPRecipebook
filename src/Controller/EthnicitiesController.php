<?php
namespace App\Controller;

use App\Controller\AppController;

class EthnicitiesController extends AppController
{
    public function index()
    {
        $ethnicities = $this->paginate($this->Ethnicities);
        $this->set(compact('ethnicities'));
    }

    public function edit($id = null)
    {
        if ($id != null && !$this->Ethnicities->exists($id)) {
            throw new NotFoundException(__('Invalid ethnicity type'));
        }

        if ($id == null) {
            $ethnicity = $this->Ethnicities->newEntity();
        } else {
            $ethnicity = $this->Ethnicities->get($id);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $ethnicity = $this->Ethnicities->patchEntity($ethnicity, $this->request->getData());
            if ($this->Ethnicities->save($ethnicity)) {
                $this->Flash->success(__('The ethnicity has been saved.'), 
                    ['params' => ['event' => 'saved.ethnicity']]);

                return $this->redirect(array('action' => 'edit'));
            }
            $this->Flash->error(__('The ethnicity could not be saved. Please, try again.'));
        }

        $this->set(compact('ethnicity')); 
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ethnicity = $this->Ethnicities->get($id);
        if ($this->Ethnicities->delete($ethnicity)) {
            $this->Flash->success(__('The ethnicity has been deleted.'));
        } else {
            $this->Flash->error(__('The ethnicity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
