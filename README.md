<h1>PHPRecipebook 5.0</h1>
=============

This is a rewrite of PHPRecipeBook hosted on sourceforge to use Cake MVC.

Great progress has been made in 2014, about 1/2 way through re-write.  CakePHP is so far a great platform for this project.  

Improvements I want to make along the way:
* AJAX Page loads (so less refreshes/data between clicks)
* Better/cleaner navigation
* HTML5 (bye bye tables)
* Better Meal Planner UI (Javascript Calendar)
* Integration with other vendors/services

And of course now that we are on GitHub contributions and collaboration should be must easier.  Look forward to anyone with some skills to jump in and keep this moving.

When the basics are working I will put up a Beta site for people to see what is coming.

There will be migration path from PHPRecipeBook 4.0

<h2>Fresh Developer Installation</h2>
<hr/>
* Get PHP Composer installed. https://getcomposer.org/download/.  Composer is used to manage dependencies and make upgrading CakePHP easier.
* Ensure you have the following PHP Modules installed: mysql, mcrypt, gd.
* Run 'php composer.phar install' in the app\ directory to get CakePHP and check dependencies.
* Create a new database to store the application in. i.e. recipebook
* Edit Configuration DB Configuration Settings ./app/Config/database.php to match your database settings. 
* Create scheme and import:
    - sudo ./app/Console/cake schema create
      * Answer Y to drop, Y to create
    - Import: SQL/core_ingredients.sql
    - Import: SQL/sample_ingredients.sql (optional)

* Edit ./app/Config/email.php to use your Email Server/Account

* For File uploads:
    - mkdir ./app/webroot/files/recipe
    - sudo chown <your web group>.<your web user> ./app/webroot/files/recipe

* Launch the website and login as:
     - User: admin
     - Password: passwd
