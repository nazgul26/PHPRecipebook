-- Schema for PHPRecipeBook 5.0
CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(32) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL DEFAULT '',
	name VARCHAR(64) NOT NULL DEFAULT '',
	access_level INTEGER NOT NULL DEFAULT '0',
        locked BOOL NOT NULL DEFAULT 0,
        reset_token VARCHAR(255) NULL,
        reset_time DATETIME NULL,
	language VARCHAR(8) DEFAULT 'en' NOT NULL,
	country VARCHAR(8) DEFAULT 'us' NOT NULL,
	last_login DATE,
	email VARCHAR(64) NOT NULL UNIQUE,
        meal_plan_start_day INT NOT NULL DEFAULT '0', -- Sunday is default
        created DATETIME,
        modified DATETIME,
	PRIMARY KEY (id)
);

CREATE TABLE stores ( 
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(32) NOT NULL DEFAULT '',
	layout TEXT,
	PRIMARY KEY (id)
);
	
CREATE TABLE ethnicities (
	id INT NOT NULL AUTO_INCREMENT,
	name CHAR(64) NOT NULL UNIQUE,
	PRIMARY KEY(id)
);

CREATE TABLE units (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	abbreviation VARCHAR(8) NOT NULL,
	system INT NOT NULL,
	sort_order INT NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE locations (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL UNIQUE,
	PRIMARY KEY(id)
);

CREATE TABLE base_types (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL UNIQUE,
	PRIMARY KEY(id));

CREATE TABLE preparation_times (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL UNIQUE,
	PRIMARY KEY(id)
);

CREATE TABLE courses (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL UNIQUE,
	PRIMARY KEY(id)
);

CREATE TABLE difficulties (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64),
	PRIMARY KEY(id)
);

CREATE TABLE preparation_methods (
    	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64),
	PRIMARY KEY(id)
);

CREATE TABLE core_ingredients (
	id INT NOT NULL,
	groupId INT NOT NULL,
	name VARCHAR(200) NOT NULL,
	short_description VARCHAR(60) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE core_weights (
	id INT NOT NULL REFERENCES core_ingredients(id) ON DELETE SET NULL,
	sequence INT NOT NULL,
	amount INT,
	measure VARCHAR(80),
	weight INT,
	PRIMARY KEY (id, sequence)
);

CREATE TABLE ingredients (
	id INT NOT NULL AUTO_INCREMENT,
	core_ingredient_id INTEGER REFERENCES core_ingredients(id) ON DELETE SET NULL,
	name VARCHAR(120) NOT NULL,
	description MEDIUMTEXT,
	location_id INT REFERENCES locations(id) ON DELETE SET NULL,
	unit_id INTEGER REFERENCES units(id) ON DELETE SET NULL,
	solid BOOL,
	system VARCHAR(8) DEFAULT 'usa',
	user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	PRIMARY KEY (id),
        UNIQUE KEY (name, user_id)
);

CREATE TABLE sources (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64),
	description MEDIUMTEXT,
	user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	PRIMARY KEY (id)
);

CREATE TABLE recipes (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    ethnicity_id INT REFERENCES ethnicities(id) ON DELETE SET NULL,
    base_type_id INT REFERENCES base_types(id) ON DELETE SET NULL,
    course_id INT REFERENCES courses(id) ON DELETE SET NULL,
    preparation_time_id INT REFERENCES preparation_times(id) ON DELETE SET NULL,
    difficulty_id INT REFERENCES difficulties(id) ON DELETE SET NULL,
    preparation_method_id INT REFERENCES preparation_methods(id) on DELETE SET NULL,
    serving_size INT,
    directions LONGTEXT,
    comments MEDIUMTEXT,
    source_id INT REFERENCES sources(id) ON DELETE SET NULL,
    source_description VARCHAR(200),
    modified DATE,
    image VARCHAR(255),
    image_dir VARCHAR(255),
    -- Need Migration script to move them to image
    --picture MEDIUMBLOB,
    --picture_type VARCHAR(32),
    private BOOL NOT NULL,
    system VARCHAR(16) DEFAULT 'usa' NOT NULL,
    user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	PRIMARY KEY (id)
);

CREATE table attachments (
    id INT NOT NULL auto_increment,
    recipe_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
    `name` varchar(32) NOT NULL,
    `attachment` varchar(255) NOT NULL,
    `dir` varchar(255) DEFAULT NULL,
    `type` varchar(255) DEFAULT NULL,
    `size` int(11) DEFAULT 0,
    sort_order INT
    PRIMARY KEY (`id`)
);

CREATE TABLE ingredient_mappings (
    id INT NOT NULL AUTO_INCREMENT,
    recipe_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
    ingredient_id INT NOT NULL REFERENCES ingredients(id) ON DELETE CASCADE,
    quantity FLOAT NOT NULL,
    unit_id INT REFERENCES units(id) ON DELETE SET NULL,
    qualifier VARCHAR(32),
    optional BOOL,
    sort_order INT,
    PRIMARY KEY (ingredient_id,recipe_id)
);

CREATE TABLE related_recipes (
    id INT NOT NULL AUTO_INCREMENT,
    parent_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
    recipe_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
    related_required BOOL,
    sort_order INT,
    PRIMARY KEY (parent_id, recipe_id)
);

CREATE TABLE shopping_lists (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    PRIMARY KEY (id)
);

CREATE TABLE shopping_list_recipes (
    id INT NOT NULL AUTO_INCREMENT,
    shopping_list_id INT NOT NULL REFERENCES shopping_lists(id) ON DELETE CASCADE,
    recipe_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
    user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    servings INT DEFAULT 1,
    PRIMARY KEY (id)
);
	
CREATE TABLE shopping_list_ingredients (
    id INT NOT NULL AUTO_INCREMENT,
    shopping_list_id INT NOT NULL REFERENCES shopping_lists(id) ON DELETE CASCADE,
    ingredient_id INT NOT NULL REFERENCES ingredients(id) ON DELETE CASCADE,
    unit_id INT NOT NULL REFERENCES units(id) ON DELETE SET NULL,
    qualifier VARCHAR(32),
    quantity FLOAT NOT NULL,
    user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    sort_order INT,
    PRIMARY KEY (id)
);

CREATE TABLE vendors (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL UNIQUE,
    home_url VARCHAR(255) NULL,
    add_url VARCHAR(255) NULL,
    PRIMARY KEY (id)
);

CREATE TABLE vendor_products (
    id INT NOT NULL AUTO_INCREMENT,
    ingredient_id INT NOT NULL REFERENCES ingredients(id) ON DELETE CASCADE,
    vendor_id INT NOT NULL REFERENCES vendors(id) ON DELETE CASCADE,
    code VARCHAR(32),
    user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    PRIMARY KEY (id)
);
	
CREATE TABLE meal_names (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE meal_plans (
    id INT NOT NULL AUTO_INCREMENT,
    mealday DATE NOT NULL,
    meal_name_id INT NOT NULL REFERENCES meal_names(id) ON DELETE CASCADE,
    recipe_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
    servings INT NOT NULL DEFAULT 0,
    user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    PRIMARY KEY (id),
    UNIQUE KEY (mealday,meal_name_id,recipe_id,user_id)
);

CREATE TABLE reviews (
    id INT NOT NULL AUTO_INCREMENT,
    recipe_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
    comments VARCHAR(255) NOT NULL,
    created DATETIME,
    rating INT,
    user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    PRIMARY KEY (id),
    UNIQUE KEY (recipe_id,comments,user_id)
);

-- TODO: copy this table into the Reviews
/*CREATE TABLE recipe_ratings (
        id INT NOT NULL AUTO_INCREMENT,
	rating_recipe INT NOT NULL REFERENCES recipe_recipes(recipe_id) ON DELETE CASCADE,
	rating_score INT NOT NULL DEFAULT 0,
	rating_ip VARCHAR(32) NOT NULL,
        PRIMARY KEY (id),
	UNIQUE KEY (rating_recipe, rating_ip));*/
	
CREATE TABLE price_ranges (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(16),
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);
	
CREATE TABLE restaurants (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    street VARCHAR(128),
    city VARCHAR(64),
    state VARCHAR(2),
    zip VARCHAR(16),
    country VARCHAR(64),
    phone VARCHAR(128),
    hours TEXT,
    picture MEDIUMBLOB,
    picture_type VARCHAR(64),
    menu_text TEXT,
    comments TEXT,
    price_range_id INT REFERENCES prices(id) ON DELETE SET NULL,
    delivery BOOL,
    carry_out BOOL,
    dine_in BOOL,
    credit BOOL,
    website VARCHAR(254),
    user_id INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);
	
INSERT INTO users (username,password,name,access_level,country,email) VALUES ('admin', '', 'Administrator', '90','us','user@localhost');
INSERT INTO stores (name, layout, user_id) VALUES('default', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43', 1);
