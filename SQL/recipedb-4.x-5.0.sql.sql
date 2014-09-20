RENAME TABLE security_users TO users;
ALTER TABLE users CHANGE user_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE users CHANGE user_login username VARCHAR(32) NOT NULL UNIQUE;
ALTER TABLE users CHANGE user_password password VARCHAR(64) NOT NULL DEFAULT '';
ALTER TABLE users CHANGE user_name name VARCHAR(64) NOT NULL DEFAULT '';
ALTER TABLE users CHANGE user_access_level access_level INTEGER NOT NULL DEFAULT '0';
ALTER TABLE users CHANGE user_language language VARCHAR(8) DEFAULT 'en' NOT NULL;
ALTER TABLE users CHANGE user_country country VARCHAR(8) DEFAULT 'us' NOT NULL;
ALTER TABLE users CHANGE user_date_created created DATETIME;
ALTER TABLE users CHANGE user_last_login last_login DATETIME;
ALTER TABLE users CHANGE user_email email VARCHAR(64) NOT NULL UNIQUE;
ALTER TABLE users ADD modified DATETIME;

RENAME TABLE security_providers TO providers;
ALTER TABLE providers CHANGE provider_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE providers CHANGE provider_name name VARCHAR(64) NOT NULL UNIQUE;

RENAME TABLE security_openid TO openids;
ALTER TABLE openids CHANGE login_id user_id INT NOT NULL;
ALTER TABLE openids CHANGE user_identity identity VARCHAR(255) NOT NULL;
ALTER TABLE openids ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY;

RENAME TABLE recipe_settings TO settings;
ALTER TABLE settings CHANGE setting_name name VARCHAR(32);
ALTER TABLE settings CHANGE setting_value value VARCHAR(64);
ALTER TABLE settings CHANGE setting_user user_id INT NULL;
ALTER TABLE settings DROP PRIMARY KEY;
ALTER TABLE settings ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE settings ADD UNIQUE (name, user_id);

RENAME TABLE recipe_stores TO stores;
ALTER TABLE stores CHANGE store_id id INT NOT NULL;
ALTER TABLE stores CHANGE store_name name VARCHAR(32) NOT NULL DEFAULT '';
ALTER TABLE stores CHANGE store_layout layout TEXT;
ALTER TABLE stores CHANGE store_user user_id VARCHAR(32) NULL;

RENAME TABLE recipe_ethnicity TO ethnicities;
ALTER TABLE ethnicities CHANGE ethnic_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE ethnicities CHANGE ethnic_desc name CHAR(64) NOT NULL UNIQUE;

RENAME TABLE recipe_units TO units;
ALTER TABLE units CHANGE unit_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE units CHANGE unit_desc name VARCHAR(64) NOT NULL;
ALTER TABLE units CHANGE unit_abbr abbreviation VARCHAR(8) NOT NULL;
ALTER TABLE units CHANGE unit_system system INT NOT NULL;
ALTER TABLE units CHANGE unit_order sort_order INT NOT NULL;

RENAME TABLE recipe_locations TO locations;
ALTER TABLE locations CHANGE location_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE locations CHANGE location_desc name VARCHAR(64) NOT NULL UNIQUE;

RENAME TABLE recipe_bases TO base_types;
ALTER TABLE base_types CHANGE base_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE base_types CHANGE base_desc name VARCHAR(64) NOT NULL UNIQUE;

RENAME TABLE recipe_prep_time TO preparation_times;
ALTER TABLE preparation_times CHANGE time_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE preparation_times CHANGE time_desc name VARCHAR(64) NOT NULL UNIQUE;

RENAME TABLE recipe_courses TO courses;
ALTER TABLE courses CHANGE course_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE courses CHANGE course_desc name VARCHAR(64) NOT NULL UNIQUE;

RENAME TABLE recipe_difficulty TO difficulties;
ALTER TABLE difficulties CHANGE difficult_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE difficulties CHANGE difficult_desc name VARCHAR(64);

RENAME TABLE recipe_core_ingredients TO core_ingredients;
ALTER TABLE core_ingredients CHANGE groupNumber group INT NOT NULL;
ALTER TABLE core_ingredients CHANGE description name VARCHAR(200) NOT NULL;

RENAME TABLE recipe_core_weights TO core_weights;

RENAME TABLE recipe_ingredients TO ingredients;
ALTER TABLE ingredients CHANGE ingredient_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE ingredients CHANGE ingredient_core core_ingredient_id INTEGER;
ALTER TABLE ingredients CHANGE ingredient_name name VARCHAR(120) NOT NULL;
ALTER TABLE ingredients CHANGE ingredient_desc description MEDIUMTEXT;
ALTER TABLE ingredients CHANGE ingredient_location location_id INT;
ALTER TABLE ingredients CHANGE ingredient_unit unit_id INTEGER;
ALTER TABLE ingredients CHANGE ingredient_solid solid BOOL;
ALTER TABLE ingredients CHANGE ingredient_system system VARCHAR(8) DEFAULT 'usa';
ALTER TABLE ingredients CHANGE ingredient_user user_id INT NULL;

RENAME TABLE recipe_sources TO sources;
ALTER TABLE sources CHANGE source_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE sources CHANGE source_title name VARCHAR(64);
ALTER TABLE sources CHANGE source_desc description MEDIUMTEXT;
ALTER TABLE sources CHANGE source_user user_id INT NULL;

RENAME TABLE recipe_recipes TO recipes;
ALTER TABLE recipes CHANGE recipe_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE recipes CHANGE recipe_name name VARCHAR(128) NOT NULL;
ALTER TABLE recipes CHANGE recipe_ethnic ethnicity_id INT;
ALTER TABLE recipes CHANGE recipe_base base_type_id INT;
ALTER TABLE recipes CHANGE recipe_course course_id INT;
ALTER TABLE recipes CHANGE recipe_prep_time preparation_time_id INT;
ALTER TABLE recipes CHANGE recipe_difficulty difficulty_id INT;
ALTER TABLE recipes CHANGE recipe_serving_size serving_size INT;
ALTER TABLE recipes CHANGE recipe_directions directions LONGTEXT;
ALTER TABLE recipes CHANGE recipe_comments comments MEDIUMTEXT;
ALTER TABLE recipes CHANGE recipe_source source_id INT;
ALTER TABLE recipes CHANGE recipe_source_desc source_description VARCHAR(200);
ALTER TABLE recipes CHANGE recipe_modified modified DATE;
ALTER TABLE recipes CHANGE recipe_picture picture MEDIUMBLOB;
ALTER TABLE recipes CHANGE recipe_picture_type picture_type VARCHAR(32);
ALTER TABLE recipes CHANGE recipe_private private BOOL NOT NULL;
ALTER TABLE recipes CHANGE recipe_system system VARCHAR(16) DEFAULT 'usa' NOT NULL;
ALTER TABLE recipes CHANGE recipe_user user_id INT NULL;

RENAME TABLE recipe_ingredient_mapping TO ingredient_mappings;
ALTER TABLE ingredient_mappings CHANGE map_recipe recipe_id INT NOT NULL;
ALTER TABLE ingredient_mappings CHANGE map_ingredient ingredient_id INT NOT NULL;
ALTER TABLE ingredient_mappings CHANGE map_quantity quantity FLOAT NOT NULL;
ALTER TABLE ingredient_mappings CHANGE map_unit unit_id INT;
ALTER TABLE ingredient_mappings CHANGE map_qualifier qualifier VARCHAR(32);
ALTER TABLE ingredient_mappings CHANGE map_optional optional BOOL;
ALTER TABLE ingredient_mappings CHANGE map_order sort_order INT NOT NULL;

DROP TABLE recipe_list_names;
CREATE TABLE shopping_list_names (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	PRIMARY KEY (id));

DROP TABLE recipe_list_recipes;
CREATE TABLE shopping_list_recipes (
        id INT NOT NULL AUTO_INCREMENT,
	shopping_list_name_id INT NOT NULL REFERENCES shopping_list_names(id) ON DELETE CASCADE,
	recipe_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
	scale FLOAT DEFAULT 0.0,
        PRIMARY KEY (id),
	UNIQUE KEY (shopping_list_name_id,recipe_id));

DROP TABLE recipe_list_ingredients;
CREATE TABLE shopping_list_ingredients (
        id INT NOT NULL AUTO_INCREMENT,
	shopping_list_name_id INT NOT NULL REFERENCES shopping_list_names(id) ON DELETE CASCADE,
	ingredient_id INT NOT NULL REFERENCES ingredients(id) ON DELETE CASCADE,
	unit_id INT NOT NULL REFERENCES units(id) ON DELETE SET NULL,
	qualifier VARCHAR(32),
	quantity FLOAT NOT NULL,
	sort_order INT,
        PRIMARY KEY (id),
	UNIQUE KEY (shopping_list_name_id,ingredient_id));

RENAME TABLE recipe_related_recipes TO related_recipes;
ALTER TABLE related_recipes CHANGE related_parent parent_id INT NOT NULL;
ALTER TABLE related_recipes CHANGE related_child recipe_id INT NOT NULL;
ALTER TABLE related_recipes CHANGE related_required required BOOL;
ALTER TABLE related_recipes CHANGE related_order sort_order INT;

DROP TABLE recipe_favorites;

RENAME TABLE recipe_meals TO meal_names;
ALTER TABLE meal_names CHANGE meal_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE meal_names CHANGE meal_name name VARCHAR(64) NOT NULL UNIQUE;

RENAME TABLE recipe_mealplans TO meal_plans;
ALTER TABLE meal_plans DROP PRIMARY KEY;
ALTER TABLE meal_plans ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE meal_plans CHANGE mplan_date mealday DATE NOT NULL;
ALTER TABLE meal_plans CHANGE mplan_meal meal_name_id INT NOT NULL;
ALTER TABLE meal_plans CHANGE mplan_recipe recipe_id INT NOT NULL;
ALTER TABLE meal_plans CHANGE mplan_servings servings INT NOT NULL DEFAULT 0;
ALTER TABLE meal_plans CHANGE mplan_user user_id INT NULL;
ALTER TABLE meal_plans ADD UNIQUE (mealday,meal_name_id,recipe_id,user_id);

RENAME TABLE recipe_reviews To reviews;
ALTER TABLE reviews DROP PRIMARY KEY;
ALTER TABLE reviews ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE reviews CHANGE review_recipe recipe_id INT NOT NULL;
ALTER TABLE reviews CHANGE review_comments comments VARCHAR(255) NOT NULL;
ALTER TABLE reviews CHANGE review_date created DATETIME;
ALTER TABLE reviews CHANGE review_user user_id INT NULL;
ALTER TABLE reviews ADD UNIQUE (recipe_id,user_id);
ALTER TABLE reviews ADD rating INT;

RENAME TABLE recipe_prices TO price_ranges;
ALTER TABLE price_ranges CHANGE price_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE price_ranges CHANGE price_desc name VARCHAR(16);
ALTER TABLE price_ranges ADD UNIQUE (name);

RENAME TABLE recipe_restaurants TO restaurants;
ALTER TABLE restaurants CHANGE restaurant_id id INT NOT NULL AUTO_INCREMENT;
ALTER TABLE restaurants CHANGE restaurant_name name VARCHAR(64) NOT NULL;
ALTER TABLE restaurants CHANGE restaurant_address street VARCHAR(128);
ALTER TABLE restaurants CHANGE restaurant_city city VARCHAR(64);
ALTER TABLE restaurants CHANGE restaurant_state state VARCHAR(2);
ALTER TABLE restaurants CHANGE restaurant_zip zip VARCHAR(16);
ALTER TABLE restaurants CHANGE restaurant_country country VARCHAR(64);
ALTER TABLE restaurants CHANGE restaurant_phone phone VARCHAR(128);
ALTER TABLE restaurants CHANGE restaurant_hours hours TEXT;
ALTER TABLE restaurants CHANGE restaurant_picture picture MEDIUMBLOB;
ALTER TABLE restaurants CHANGE restaurant_picture_type picture_type VARCHAR(64);
ALTER TABLE restaurants CHANGE restaurant_menu_text menu_text TEXT;
ALTER TABLE restaurants CHANGE restaurant_comments comments TEXT;
ALTER TABLE restaurants CHANGE restaurant_price price_range_id INT;
ALTER TABLE restaurants CHANGE restaurant_delivery delivery BOOL;
ALTER TABLE restaurants CHANGE restaurant_carry_out carry_out BOOL;
ALTER TABLE restaurants CHANGE restaurant_dine_in dine_in BOOL;
ALTER TABLE restaurants CHANGE restaurant_credit credit BOOL;
ALTER TABLE restaurants CHANGE restaurant_website website VARCHAR(254);
ALTER TABLE restaurants CHANGE restaurant_user user_id INT NULL;
ALTER TABLE restaurants ADD UNIQUE (name, user_id);

CREATE TABLE preparation_methods (
    	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64),
	PRIMARY KEY(id)
);
ALTER TABLE recipes ADD preparation_method_id INT REFERENCES preparation_methods(id) on DELETE SET NULL;
