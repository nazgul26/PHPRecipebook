<?php

App::uses('ClassRegistry', 'Utility');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class AppSchema extends CakeSchema
{
    public function before($event = [])
    {
        $db = ConnectionManager::getDataSource($this->connection);
        $db->cacheSources = false;

        return true;
    }

    public function after($event = [])
    {
        if (isset($event['create'])) {
            $table = $event['create'];
            $data = null;
            switch ($table) {
                    case 'base_types':
                        $data = [
                            ['name' => __('Beef')],
                            ['name' => __('Bread')],
                            ['name' => __('Egg')],
                            ['name' => __('Fruit')],
                            ['name' => __('Grain')],
                            ['name' => __('Lamb')],
                            ['name' => __('Other')],
                            ['name' => __('Pasta')],
                            ['name' => __('Pork/Ham')],
                            ['name' => __('Poultry')],
                            ['name' => __('Seafood')],
                            ['name' => __('Vegetable')],
                        ];
                        break;
                    case 'courses':
                        $data = [
                            ['name' => __('Breakfast')],
                            ['name' => __('Snack')],
                            ['name' => __('Lunch')],
                            ['name' => __('Appetizer')],
                            ['name' => __('Side Dish')],
                            ['name' => __('Entree')],
                            ['name' => __('Dessert')],
                            ['name' => __('Beverage')],

                        ];
                        break;
                    case 'difficulties':
                        $data = [
                            ['name' => __('Easy')],
                            ['name' => __('Intermediate')],
                            ['name' => __('Difficult')],
                            ['name' => __('Expert')],
                        ];
                        break;
                    case 'ethnicities':
                        $data = [
                            ['name' => __('American')],
                            ['name' => __('Chinese')],
                            ['name' => __('German')],
                            ['name' => __('Greek')],
                            ['name' => __('Indian')],
                            ['name' => __('Italian')],
                            ['name' => __('Japanese')],
                            ['name' => __('Mexican')],
                            ['name' => __('Middle Eastern')],
                            ['name' => __('None')],
                            ['name' => __('Slavic')],
                        ];
                        break;
                    case 'locations':
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
                            ['name' => __('Toilet Paper')],
                        ];
                        break;
                    case 'meal_names':
                        $data = [
                            ['name' => __('Breakfast')],
                            ['name' => __('Lunch')],
                            ['name' => __('Dinner')],
                            ['name' => __('Dessert')],
                        ];
                        break;
                    case 'preparation_methods':
                        $data = [
                            ['name' => __('Slow cooker')],
                            ['name' => __('Microwave')],
                            ['name' => __('BBQ')],
                            ['name' => __('Canning')],
                        ];
                        break;
                    case 'preparation_times':
                        $data = [
                            ['name' => __('0 Minutes')],
                            ['name' => __('1-10 Minutes')],
                            ['name' => __('10-30 Minutes')],
                            ['name' => __('30-60 Minutes')],
                            ['name' => __('60+ Minutes')],
                        ];
                        break;
                    case 'price_ranges':
                        $data = [
                            ['name' => __('$0-$10')],
                            ['name' => __('$10-$15')],
                            ['name' => __('$15-$20')],
                            ['name' => __('$20-$25')],
                            ['name' => __('$25-$30')],
                            ['name' => __('$30+')],
                        ];
                        break;
                    case 'stores':
                        $data = [
                            [
                                'name'   => 'default',
                                'layout' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40',
                                ],
                        ];
                        break;
                    case 'units':
                        $data = [
                            ['id' => 1, 'name' => __('Unit'), 'abbreviation' => 'ea', 'system' => 0, 'sort_order' => 0],
                            ['id' => 2, 'name' => __('Slice'), 'abbreviation' => 'sli', 'system' => 0, 'sort_order' => 0],
                            ['id' => 3, 'name' => __('Clove'), 'abbreviation' => 'clv', 'system' => 0, 'sort_order' => 0],
                            ['id' => 4, 'name' => __('Pinch'), 'abbreviation' => 'pn', 'system' => 0, 'sort_order' => 0],
                            ['id' => 5, 'name' => __('Package'), 'abbreviation' => 'pk', 'system' => 0, 'sort_order' => 0],
                            ['id' => 6, 'name' => __('Can'), 'abbreviation' => 'cn', 'system' => 0, 'sort_order' => 0],
                            ['id' => 7, 'name' => __('Drop'), 'abbreviation' => 'dr', 'system' => 0, 'sort_order' => 0],
                            ['id' => 8, 'name' => __('Bunch'), 'abbreviation' => 'bn', 'system' => 0, 'sort_order' => 0],
                            ['id' => 9, 'name' => __('Dash'), 'abbreviation' => 'ds', 'system' => 0, 'sort_order' => 0],
                            ['id' => 10, 'name' => __('Carton'), 'abbreviation' => 'ct', 'system' => 0, 'sort_order' => 0],
                            ['id' => 11, 'name' => __('Cup'), 'abbreviation' => 'c', 'system' => 1, 'sort_order' => 0],
                            ['id' => 12, 'name' => __('Tablespoon'), 'abbreviation' => 'T', 'system' => 1, 'sort_order' => 0],
                            ['id' => 13, 'name' => __('Teaspoon'), 'abbreviation' => 't', 'system' => 1, 'sort_order' => 0],
                            ['id' => 14, 'name' => __('Pound'), 'abbreviation' => 'lb', 'system' => 1, 'sort_order' => 0],
                            ['id' => 15, 'name' => __('Ounce'), 'abbreviation' => 'oz', 'system' => 1, 'sort_order' => 0],
                            ['id' => 16, 'name' => __('Pint'), 'abbreviation' => 'pt', 'system' => 1, 'sort_order' => 0],
                            ['id' => 17, 'name' => __('Quart'), 'abbreviation' => 'q', 'system' => 1, 'sort_order' => 0],
                            ['id' => 18, 'name' => __('Gallon'), 'abbreviation' => 'gal', 'system' => 1, 'sort_order' => 0],
                            ['id' => 19, 'name' => __('Milligram'), 'abbreviation' => 'mg', 'system' => 2, 'sort_order' => 0],
                            ['id' => 20, 'name' => __('Centigram'), 'abbreviation' => 'cg', 'system' => 2, 'sort_order' => 0],
                            ['id' => 21, 'name' => __('Gram'), 'abbreviation' => 'g', 'system' => 2, 'sort_order' => 0],
                            ['id' => 22, 'name' => __('Kilogram'), 'abbreviation' => 'kg', 'system' => 2, 'sort_order' => 0],
                            ['id' => 23, 'name' => __('Milliliter'), 'abbreviation' => 'ml', 'system' => 2, 'sort_order' => 0],
                            ['id' => 24, 'name' => __('Centiliter'), 'abbreviation' => 'cl', 'system' => 2, 'sort_order' => 0],
                            ['id' => 25, 'name' => __('Liter'), 'abbreviation' => 'l', 'system' => 2, 'sort_order' => 0],
                            ['id' => 26, 'name' => __('Deciliter'), 'abbreviation' => 'dl', 'system' => 2, 'sort_order' => 0],
                            ['id' => 27, 'name' => __('Tablespoon_m'), 'abbreviation' => 'tbsp', 'system' => 2, 'sort_order' => 0],
                            ['id' => 28, 'name' => __('Teaspoon_m'), 'abbreviation' => 'tsp', 'system' => 2, 'sort_order' => 0],
                        ];
                        break;
                    case 'users':
                        $passwordHasher = new BlowfishPasswordHasher();
                        $data = [
                             [
                                'username'     => 'admin',
                                'password'     => $passwordHasher->hash('passwd'),
                                'name'         => 'Administrator',
                                'access_level' => Configure::read('AuthRoles.admin'),
                                'email'        => 'user@localhost', ],
                        ];
                        break;
                    case 'vendors':
                        $data = [
                            ['name'        => 'Presto Fresh Grocery',
                                'home_url' => 'http://www.prestofreshgrocery.com/checkout/cart/',
                                'add_url'  => 'http://www.prestofreshgrocery.com/checkout/cart/add/uenc/a/product/@productId/qty/1?block%5B%5D=options&awacp=1&no_cache=1',
                            ],
                        ];
                        break;

                    default:
                }
            if ($data) {
                ClassRegistry::init($table)->saveAll($data);
            }
        }
    }

    public $attachments = [
        'id'         => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'recipe_id'  => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'name'       => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'attachment' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'dir'        => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'type'       => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'size'       => ['type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false],
        'sort_order' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes'    => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'],
    ];

    public $base_types = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'name'    => ['column' => 'name', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $courses = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $difficulties = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $ethnicities = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $ingredient_mappings = [
        'recipe_id'     => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'ingredient_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'quantity'      => ['type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false],
        'unit_id'       => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'qualifier'     => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'optional'      => ['type' => 'boolean', 'null' => true, 'default' => null],
        'sort_order'    => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'id'            => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'indexes'       => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $ingredients = [
        'id'          => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'        => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'description' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'location_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'unit_id'     => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'solid'       => ['type' => 'boolean', 'null' => true, 'default' => null],
        'system'      => ['type' => 'string', 'null' => true, 'default' => 'usa', 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'user_id'     => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes'     => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $locations = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $meal_names = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY'   => ['column' => 'id', 'unique' => 1],
            'meal_name' => ['column' => 'name', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $meal_plans = [
        'mealday'      => ['type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'],
        'meal_name_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'recipe_id'    => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'servings'     => ['type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false],
        'user_id'      => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'id'           => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'indexes'      => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'mealday' => ['column' => ['mealday', 'meal_name_id', 'recipe_id', 'user_id'], 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $preparation_methods = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'],
    ];

    public $preparation_times = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $price_ranges = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 16, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $recipes = [
        'id'                    => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'                  => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'ethnicity_id'          => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'base_type_id'          => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'course_id'             => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'preparation_time_id'   => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'difficulty_id'         => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'serving_size'          => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'directions'            => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'comments'              => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'source_description'    => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'recipe_cost'           => ['type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false],
        'modified'              => ['type' => 'date', 'null' => true, 'default' => null],
        'picture'               => ['type' => 'binary', 'null' => true, 'default' => null],
        'picture_type'          => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'private'               => ['type' => 'boolean', 'null' => false, 'default' => null],
        'system'                => ['type' => 'string', 'null' => false, 'default' => 'usa', 'length' => 16, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'source_id'             => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'user_id'               => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'preparation_method_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes'               => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $related_recipes = [
        'parent_id'  => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'recipe_id'  => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'required'   => ['type' => 'boolean', 'null' => true, 'default' => null],
        'sort_order' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'id'         => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'indexes'    => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $reviews = [
        'recipe_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'],
        'comments'  => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'created'   => ['type' => 'datetime', 'null' => true, 'default' => null],
        'user_id'   => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'id'        => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'rating'    => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes'   => [
            'PRIMARY'   => ['column' => 'id', 'unique' => 1],
            'recipe_id' => ['column' => ['recipe_id', 'user_id'], 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $restaurants = [
        'id'             => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'           => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'street'         => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'city'           => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'state'          => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'zip'            => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 16, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'phone'          => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'hours'          => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'picture'        => ['type' => 'binary', 'null' => true, 'default' => null],
        'picture_type'   => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'menu_text'      => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'comments'       => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'price_range_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'delivery'       => ['type' => 'boolean', 'null' => true, 'default' => null],
        'carry_out'      => ['type' => 'boolean', 'null' => true, 'default' => null],
        'dine_in'        => ['type' => 'boolean', 'null' => true, 'default' => null],
        'credit'         => ['type' => 'boolean', 'null' => true, 'default' => null],
        'user_id'        => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'website'        => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 254, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'country'        => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes'        => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $shopping_list_ingredients = [
        'id'               => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'shopping_list_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'ingredient_id'    => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'unit_id'          => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'qualifier'        => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'quantity'         => ['type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false],
        'user_id'          => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes'          => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'],
    ];

    public $shopping_list_recipes = [
        'id'               => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'shopping_list_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'recipe_id'        => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'servings'         => ['type' => 'integer', 'null' => true, 'default' => '1', 'unsigned' => false],
        'user_id'          => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes'          => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'],
    ];

    public $shopping_lists = [
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'    => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'user_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'],
    ];

    public $sources = [
        'id'          => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'        => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'description' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'user_id'     => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes'     => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $stores = [
        'name'    => ['type' => 'string', 'null' => false, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'layout'  => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'id'      => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $units = [
        'id'           => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'         => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'abbreviation' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'system'       => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'sort_order'   => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'indexes'      => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $users = [
        'username'            => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'password'            => ['type' => 'string', 'null' => false, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'name'                => ['type' => 'string', 'null' => false, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'access_level'        => ['type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false],
        'language'            => ['type' => 'string', 'null' => false, 'default' => 'en', 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'country'             => ['type' => 'string', 'null' => false, 'default' => 'us', 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'created'             => ['type' => 'datetime', 'null' => true, 'default' => null],
        'last_login'          => ['type' => 'datetime', 'null' => true, 'default' => null],
        'email'               => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'id'                  => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'modified'            => ['type' => 'datetime', 'null' => true, 'default' => null],
        'reset_token'         => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'locked'              => ['type' => 'boolean', 'null' => false, 'default' => '0'],
        'reset_time'          => ['type' => 'datetime', 'null' => true, 'default' => null],
        'meal_plan_start_day' => ['type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false],
        'indexes'             => [
            'PRIMARY'    => ['column' => 'id', 'unique' => 1],
            'user_email' => ['column' => 'email', 'unique' => 1],
            'user_login' => ['column' => 'username', 'unique' => 1],
            'username'   => ['column' => 'username', 'unique' => 1],
            'email'      => ['column' => 'email', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'],
    ];

    public $vendor_products = [
        'id'            => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'ingredient_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'vendor_id'     => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'code'          => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'user_id'       => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'name'          => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes'       => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'],
    ];

    public $vendors = [
        'id'           => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name'         => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'home_url'     => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'add_url'      => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'request_type' => ['type' => 'string', 'null' => true, 'default' => 'GET', 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'format'       => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'],
        'indexes'      => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'],
    ];
}
