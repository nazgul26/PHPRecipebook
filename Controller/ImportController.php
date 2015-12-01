<?php

App::uses('AppController', 'Controller');

class ImportController extends AppController {
    public $components = array('MealMaster');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny(); // Deny ALL, user must be logged in.
    }

    public function index($id = null) {
        if ($this->request->is(array('post', 'put'))) {
            if (!empty($this->request->data['MealMaster']['mm_file']['tmp_name'])
                && is_uploaded_file($this->request->data['MealMaster']['mm_file']['tmp_name'])) {
                
                $filename = $this->request->data['MealMaster']['mm_file']['tmp_name'];
                $data = $this->MealMaster->parseDataFile($filename);
            } else {
                $this->Session->setFlash(__('Could not open uploaded file, please try again.'));
            }
        }
    }
}

