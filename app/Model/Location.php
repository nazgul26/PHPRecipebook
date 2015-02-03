<?php
App::uses('AppModel', 'Model');
/**
 * Location Model
 *
 */
class Location extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    
    public function orderShoppingListByLocation($list) {
        $sortedList = array();
        $locations = $this->find('all', array('order' => array('name')));
        foreach ($locations as $location) {
            foreach ($list as $item) {
                if ($item[0]->locationId == $location['Location']['id']) {
                    $item[0]->locationName = $location['Location']['name'];
                    $sortedList[] = $item;
                }
            }
        }
        return $sortedList;
    }

}
