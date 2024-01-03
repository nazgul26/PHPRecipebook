<?php
use Migrations\AbstractSeed;

class UnitsSeed extends AbstractSeed
{
    public function run() : void
    {               
        $data = [
            ['id' => 1, 'name' => __('Unit'), 'abbreviation' =>  'ea', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 2, 'name' => __('Slice'), 'abbreviation' =>  'sli', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 3, 'name' => __('Clove'), 'abbreviation' =>  'clv', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 4, 'name' => __('Pinch'), 'abbreviation' =>  'pn', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 5, 'name' => __('Package'), 'abbreviation' =>  'pk', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 6, 'name' => __('Can'), 'abbreviation' =>  'cn', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 7, 'name' => __('Drop'), 'abbreviation' =>  'dr', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 8, 'name' => __('Bunch'), 'abbreviation' =>  'bn', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 9, 'name' => __('Dash'), 'abbreviation' =>  'ds', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 10, 'name' => __('Carton'), 'abbreviation' =>  'ct', 'system_type' => 0, 'sort_order' => 0],
            ['id' => 11, 'name' => __('Cup'), 'abbreviation' =>  'c', 'system_type' => 1, 'sort_order' => 0],
            ['id' => 12, 'name' => __('Tablespoon'), 'abbreviation' =>  'T', 'system_type' => 1, 'sort_order' => 0],
            ['id' => 13, 'name' => __('Teaspoon'), 'abbreviation' =>  't', 'system_type' => 1, 'sort_order' => 0],
            ['id' => 14, 'name' => __('Pound'), 'abbreviation' =>  'lb', 'system_type' => 1, 'sort_order' => 0],
            ['id' => 15, 'name' => __('Ounce'), 'abbreviation' =>  'oz', 'system_type' => 1, 'sort_order' => 0],
            ['id' => 16, 'name' => __('Pint'), 'abbreviation' =>  'pt', 'system_type' => 1, 'sort_order' => 0],
            ['id' => 17, 'name' => __('Quart'), 'abbreviation' =>  'q', 'system_type' => 1, 'sort_order' => 0],
            ['id' => 18, 'name' => __('Gallon'), 'abbreviation' =>  'gal', 'system_type' => 1, 'sort_order' => 0],
            ['id' => 19, 'name' => __('Milligram'), 'abbreviation' =>  'mg', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 20, 'name' => __('Centigram'), 'abbreviation' =>  'cg', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 21, 'name' => __('Gram'), 'abbreviation' =>  'g', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 22, 'name' => __('Kilogram'), 'abbreviation' =>  'kg', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 23, 'name' => __('Milliliter'), 'abbreviation' =>  'ml', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 24, 'name' => __('Centiliter'), 'abbreviation' =>  'cl', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 25, 'name' => __('Liter'), 'abbreviation' =>  'l', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 26, 'name' => __('Deciliter'), 'abbreviation' =>  'dl', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 27, 'name' => __('Tablespoon_m'), 'abbreviation' =>  'tbsp', 'system_type' => 2, 'sort_order' => 0],
            ['id' => 28, 'name' => __('Teaspoon_m'), 'abbreviation' =>  'tsp', 'system_type' => 2, 'sort_order' => 0],
        ];
        $table = $this->table('units');
        $table->insert($data)->save();
    }
}