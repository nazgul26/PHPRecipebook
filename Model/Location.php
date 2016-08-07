<?php

App::uses('AppModel', 'Model');
/**
 * Location Model.
 */
class Location extends AppModel
{
    public $displayField = 'name';

    public function orderShoppingListByLocation($list)
    {
        $sortedList = [];
        $locations = $this->find('all', ['order' => ['name']]);
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

    public function orderShoppingListByStore($list, $locationIds)
    {
        $sortedList = [];
        foreach ($locationIds as $id) {
            $location = $this->findById($id);
            if (isset($location['Location'])) {
                foreach ($list as $item) {
                    if ($item[0]->locationId == $location['Location']['id']) {
                        $item[0]->locationName = $location['Location']['name'];
                        $sortedList[] = $item;
                    }
                }
            }
        }

        return $sortedList;
    }
}
