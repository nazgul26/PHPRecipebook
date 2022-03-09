<?php
use Migrations\AbstractSeed;

class LocationsSeed extends AbstractSeed
{
    public function run()
    {               
        $data = [
            ['name' => __('Alcohol')],
            ['name' => __('Bakery')],
            ['name' => __('Beans')],
            ['name' => __('Bread')],
            ['name' => __('Candy')],
            ['name' => __('Canned Fruit')],
            ['name' => __('Canned Meat & Fish')],
            ['name' => __('Canned Vegetables')],
            ['name' => __('Coffee, Tea & Cocoa')],
            ['name' => __('Condiments')],
            ['name' => __('Cookies')],
            ['name' => __('Crackers')],
            ['name' => __('Dairy')],
            ['name' => __('Deli')],
            ['name' => __('Drink mix')],
            ['name' => __('Facial Tissue')],
            ['name' => __('Free')],
            ['name' => __('Frozen Foods')],
            ['name' => __('HABA')],
            ['name' => __('Hand Soap')],
            ['name' => __('Hot & Cold Cereal')],
            ['name' => __('Household Cleaners')],
            ['name' => __('Juice & Cocktail')],
            ['name' => __('Kosher/Ethnic')],
            ['name' => __('Laundry Detergents')],
            ['name' => __('Meat')],
            ['name' => __('Natural & Organic')],
            ['name' => __('Oil/Vinegar/Dressings')],
            ['name' => __('Pancakes & Syrup')],
            ['name' => __('Paper Serving Ware')],
            ['name' => __('Pasta & Sauce')],
            ['name' => __('Peanut Butter/Jelly/Honey')],
            ['name' => __('Produce')],
            ['name' => __('Rice')],
            ['name' => __('Salty Snacks & Chips')],
            ['name' => __('Seafood')],
            ['name' => __('Soda pop')],
            ['name' => __('Soup')],
            ['name' => __('Spices')],
            ['name' => __('Toilet Paper')]
        ];
        $table = $this->table('locations');
        $table->insert($data)->save();
    }
}
