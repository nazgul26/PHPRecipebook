<?php 
App::uses('ClassRegistry', 'Utility');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class AppSchema extends CakeSchema {
    
	public function before($event = array()) {
            $db = ConnectionManager::getDataSource($this->connection);
            $db->cacheSources = false;
            return true;
	}
        
	public function after($event = array()) {
            if (isset($event['create'])) {
                $table = $event['create'];
                $data = null;
                switch($table) {
                    case 'base_types':
                        $data = array(
                            array('name' => __('Beef')),
                            array('name' => __('Bread')),
                            array('name' => __('Egg')),
                            array('name' => __('Fruit')),
                            array('name' => __('Grain')),
                            array('name' => __('Lamb')),
                            array('name' => __('Other')),
                            array('name' => __('Pasta')),
                            array('name' => __('Pork/Ham')),
                            array('name' => __('Poultry')),
                            array('name' => __('Seafood')),
                            array('name' => __('Vegetable'))
                        );
                        break;
                    case 'courses':
                        $data = array(
                            array('name' => __('Breakfast')),
                            array('name' => __('Snack')),
                            array('name' => __('Lunch')),
                            array('name' => __('Appetizer')),
                            array('name' => __('Side Dish')),
                            array('name' => __('Entree')),
                            array('name' => __('Dessert')),
                            array('name' => __('Beverage'))
     
                        );
                        break;
                    case 'difficulties':
                        $data = array(
                            array('name' => __('Easy')),
                            array('name' => __('Intermediate')),
                            array('name' => __('Difficult')),
                            array('name' => __('Expert'))
                        );
                        break;
                    case 'ethnicities':
                        $data = array( 
                            array('name' => __('American')),
                            array('name' => __('Chinese')),
                            array('name' => __('German')),
                            array('name' => __('Greek')),
                            array('name' => __('Indian')),
                            array('name' => __('Italian')),
                            array('name' => __('Japanese')),
                            array('name' => __('Mexican')),
                            array('name' => __('Middle Eastern')),
                            array('name' => __('None')),
                            array('name' => __('Slavic'))
                        );
                        break;
                    case 'locations':
                        $data = array(
                            array('name' => __('Alcohol')),
                            array('name' => __('Bakery')),
                            array('name' => __('Beans')),
                            array('name' => __('Bread')),
                            array('name' => __('Candy')),
                            array('name' => __('Canned Fruit')),
                            array('name' => __('Canned Meat & Fish')),
                            array('name' => __('Canned Vegetables')),
                            array('name' => __('Coffee, Tea & Cocoa')),
                            array('name' => __('Condiments')),
                            array('name' => __('Cookies')),
                            array('name' => __('Crackers')),
                            array('name' => __('Dairy')),
                            array('name' => __('Deli')),
                            array('name' => __('Drink mix')),
                            array('name' => __('Facial Tissue')),
                            array('name' => __('Free')),
                            array('name' => __('Frozen Foods')),
                            array('name' => __('HABA')),
                            array('name' => __('Hand Soap')),
                            array('name' => __('Hot & Cold Cereal')),
                            array('name' => __('Household Cleaners')),
                            array('name' => __('Juice & Cocktail')),
                            array('name' => __('Kosher/Ethnic')),
                            array('name' => __('Laundry Detergents')),
                            array('name' => __('Meat')),
                            array('name' => __('Natural & Organic')),
                            array('name' => __('Oil/Vinegar/Dressings')),
                            array('name' => __('Pancakes & Syrup')),
                            array('name' => __('Paper Serving Ware')),
                            array('name' => __('Pasta & Sauce')),
                            array('name' => __('Peanut Butter/Jelly/Honey')),
                            array('name' => __('Produce')),
                            array('name' => __('Rice')),
                            array('name' => __('Salty Snacks & Chips')),
                            array('name' => __('Seafood')),
                            array('name' => __('Soda pop')),
                            array('name' => __('Soup')),
                            array('name' => __('Spices')),
                            array('name' => __('Toilet Paper'))
                        );
                        break;
                    case 'meal_names':
                        $data = array(
                            array('name' => __('Breakfast')),
                            array('name' => __('Lunch')),
                            array('name' => __('Dinner')),
                            array('name' => __('Dessert'))
                        );
                        break;
                    case 'preparation_methods':
                        $data = array(
                            array('name' => __('Slow cooker')),
                            array('name' => __('Microwave')),
                            array('name' => __('BBQ')),
                            array('name' => __('Canning')),
                        );
                        break;
                    case 'preparation_times':
                        $data = array(
                            array('name' => __('0 Minutes')),
                            array('name' => __('1-10 Minutes')),
                            array('name' => __('10-30 Minutes')),
                            array('name' => __('30-60 Minutes')),
                            array('name' => __('60+ Minutes'))
                        );
                        break;
                    case 'price_ranges': 
                        $data = array(
                            array('name' => __('$0-$10')),
                            array('name' => __('$10-$15')),
                            array('name' => __('$15-$20')),
                            array('name' => __('$20-$25')),
                            array('name' => __('$25-$30')),
                            array('name' => __('$30+'))     
                        );
                        break;
                    case 'stores':
                        $data = array(
                            array(
                                'name' => 'default',
                                'layout' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40'
                                )
                        );
                        break;   
                    case 'units':
                        $data = array(
                            array('id' => 1, 'name' => __('Unit'), 'abbreviation' =>  'ea', 'system' => 0, 'sort_order' => 0),
                            array('id' => 2, 'name' => __('Slice'), 'abbreviation' =>  'sli', 'system' => 0, 'sort_order' => 0),
                            array('id' => 3, 'name' => __('Clove'), 'abbreviation' =>  'clv', 'system' => 0, 'sort_order' => 0),
                            array('id' => 4, 'name' => __('Pinch'), 'abbreviation' =>  'pn', 'system' => 0, 'sort_order' => 0),
                            array('id' => 5, 'name' => __('Package'), 'abbreviation' =>  'pk', 'system' => 0, 'sort_order' => 0),
                            array('id' => 6, 'name' => __('Can'), 'abbreviation' =>  'cn', 'system' => 0, 'sort_order' => 0),
                            array('id' => 7, 'name' => __('Drop'), 'abbreviation' =>  'dr', 'system' => 0, 'sort_order' => 0),
                            array('id' => 8, 'name' => __('Bunch'), 'abbreviation' =>  'bn', 'system' => 0, 'sort_order' => 0),
                            array('id' => 9, 'name' => __('Dash'), 'abbreviation' =>  'ds', 'system' => 0, 'sort_order' => 0),
                            array('id' => 10, 'name' => __('Carton'), 'abbreviation' =>  'ct', 'system' => 0, 'sort_order' => 0),
                            array('id' => 11, 'name' => __('Cup'), 'abbreviation' =>  'c', 'system' => 1, 'sort_order' => 0),
                            array('id' => 12, 'name' => __('Tablespoon'), 'abbreviation' =>  'T', 'system' => 1, 'sort_order' => 0),
                            array('id' => 13, 'name' => __('Teaspoon'), 'abbreviation' =>  't', 'system' => 1, 'sort_order' => 0),
                            array('id' => 14, 'name' => __('Pound'), 'abbreviation' =>  'lb', 'system' => 1, 'sort_order' => 0),
                            array('id' => 15, 'name' => __('Ounce'), 'abbreviation' =>  'oz', 'system' => 1, 'sort_order' => 0),
                            array('id' => 16, 'name' => __('Pint'), 'abbreviation' =>  'pt', 'system' => 1, 'sort_order' => 0),
                            array('id' => 17, 'name' => __('Quart'), 'abbreviation' =>  'q', 'system' => 1, 'sort_order' => 0),
                            array('id' => 18, 'name' => __('Gallon'), 'abbreviation' =>  'gal', 'system' => 1, 'sort_order' => 0),
                            array('id' => 19, 'name' => __('Milligram'), 'abbreviation' =>  'mg', 'system' => 2, 'sort_order' => 0),
                            array('id' => 20, 'name' => __('Centigram'), 'abbreviation' =>  'cg', 'system' => 2, 'sort_order' => 0),
                            array('id' => 21, 'name' => __('Gram'), 'abbreviation' =>  'g', 'system' => 2, 'sort_order' => 0),
                            array('id' => 22, 'name' => __('Kilogram'), 'abbreviation' =>  'kg', 'system' => 2, 'sort_order' => 0),
                            array('id' => 23, 'name' => __('Milliliter'), 'abbreviation' =>  'ml', 'system' => 2, 'sort_order' => 0),
                            array('id' => 24, 'name' => __('Centiliter'), 'abbreviation' =>  'cl', 'system' => 2, 'sort_order' => 0),
                            array('id' => 25, 'name' => __('Liter'), 'abbreviation' =>  'l', 'system' => 2, 'sort_order' => 0),
                            array('id' => 26, 'name' => __('Deciliter'), 'abbreviation' =>  'dl', 'system' => 2, 'sort_order' => 0),
                            array('id' => 27, 'name' => __('Tablespoon_m'), 'abbreviation' =>  'tbsp', 'system' => 2, 'sort_order' => 0),
                            array('id' => 28, 'name' => __('Teaspoon_m'), 'abbreviation' =>  'tsp', 'system' => 2, 'sort_order' => 0),
                        );
                        break;
                    case 'users':
                        $passwordHasher = new BlowfishPasswordHasher();
                        $data = array(
                            array (
                                'username' => 'admin', 
                                'password' => $passwordHasher->hash('passwd'), 
                                'name' => 'Administrator', 
                                'access_level' => Configure::read('AuthRoles.admin'), 
                                'email' => 'user@localhost')
                        );
                        break; 
                    case 'vendors':
                        $data = array(
                            array('name' => 'Presto Fresh Grocery', 
                                'home_url' => 'http://www.prestofreshgrocery.com/',
                                'add_url' => 'http://www.prestofreshgrocery.com/checkout/cart/add/uenc/a/product/'
                            )
                        );
                        break;
                    default:
                }
                if ($data) {
                    ClassRegistry::init($table)->saveAll($data);
                }
            }
        }

	public $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'recipe_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'attachment' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dir' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'size' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'sort_order' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $base_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $core_ingredients = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'groupNumber' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'short_description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $core_weights = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'sequence' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'amount' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'measure' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		/*'indexes' => array(
			'PRIMARY' => array('column' => array('id', 'sequence'), 'unique' => 1)
		),*/
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $courses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			//'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $difficulties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $ethnicities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			//'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $ingredient_mappings = array(
		'recipe_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'ingredient_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'quantity' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'unit_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'qualifier' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'optional' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'sort_order' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $ingredients = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'location_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'unit_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'solid' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'system' => array('type' => 'string', 'null' => true, 'default' => 'usa', 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'core_ingredient_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			//'ingredient_name' => array('column' => array('name', 'user_id'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $locations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			//'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $meal_names = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'meal_name' => array('column' => 'name', 'unique' => 1),
			//'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $meal_plans = array(
		'mealday' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'meal_name_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'recipe_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'servings' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'mealday' => array('column' => array('mealday', 'meal_name_id', 'recipe_id', 'user_id'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $preparation_methods = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $preparation_times = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			//'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $price_ranges = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 16, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			//'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $recipes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ethnicity_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'base_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'course_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'preparation_time_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'difficulty_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'serving_size' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'directions' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'source_description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'recipe_cost' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'modified' => array('type' => 'date', 'null' => true, 'default' => null),
		'picture' => array('type' => 'binary', 'null' => true, 'default' => null),
		'picture_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'private' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'system' => array('type' => 'string', 'null' => false, 'default' => 'usa', 'length' => 16, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'source_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'preparation_method_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $related_recipes = array(
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'recipe_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'required' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'sort_order' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $restaurants = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'street' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'state' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'zip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 16, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'hours' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'picture' => array('type' => 'binary', 'null' => true, 'default' => null),
		'picture_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'menu_text' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'price_range_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'delivery' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'carry_out' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'dine_in' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'credit' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 254, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'country' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			//'name' => array('column' => array('name', 'user_id'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $shopping_list_ingredients = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'shopping_list_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'ingredient_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'unit_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'qualifier' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'quantity' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $shopping_list_recipes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'shopping_list_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'recipe_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'servings' => array('type' => 'integer', 'null' => true, 'default' => '1', 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $shopping_lists = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $sources = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $stores = array(
		'name' => array('type' => 'string', 'null' => false, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'layout' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $units = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'abbreviation' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'system' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'sort_order' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $users = array(
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => false, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'access_level' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'language' => array('type' => 'string', 'null' => false, 'default' => 'en', 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'country' => array('type' => 'string', 'null' => false, 'default' => 'us', 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'last_login' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'reset_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'locked' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'reset_time' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'meal_plan_start_day' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_email' => array('column' => 'email', 'unique' => 1),
			'user_login' => array('column' => 'username', 'unique' => 1),
			'username' => array('column' => 'username', 'unique' => 1),
			'email' => array('column' => 'email', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	public $vendor_products = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'ingredient_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'vendor_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $vendors = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'home_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'add_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			//'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

}
