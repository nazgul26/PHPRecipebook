<?php
/*
 * This class provides a way to flatten the database model into a single class 
 * which simplifies coding needed to manipulate the list.
 */
class ListItem extends AppModel {
    public $useTable = false;
    
    public $name;
    public $id;
    public $unitId;
    public $unitName;
    public $quantity;  
}
?>

