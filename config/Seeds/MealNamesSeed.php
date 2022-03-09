<?php
use Migrations\AbstractSeed;

class MealNamesSeed extends AbstractSeed
{
    public function run()
    {               
        $data = [
            ['name' => __('Breakfast')],
            ['name' => __('Lunch')],
            ['name' => __('Dinner')],
            ['name' => __('Dessert')],
        ];
        $table = $this->table('meal_names');
        $table->insert($data)->save();
    }
}