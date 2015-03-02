<h1>PHPRecipebook 5.0</h1>
=============

This is a rewrite of PHPRecipeBook hosted on sourceforge to use Cake MVC.

Current code is now ready for preview usage.  A setup wizard is included and a complete migration script.

A preview site will be available in the next couple of weeks.

Improvements:
* AJAX Page loads (so less refreshes/data between clicks)
* Better/cleaner navigation
* HTML5 (bye bye tables)
* Better Meal Planner UI
* Integration with other vendors/services
* More databases supported because of CakePHP abstraction

And of course now that we are on GitHub contributions and collaboration should be must easier.  Look forward to anyone with some skills to jump in and keep this moving.

<h2>Fresh Developer Installation</h2>
<hr/>
* Get PHP Composer installed. https://getcomposer.org/download/.  Composer is used to manage dependencies and make upgrading CakePHP easier.
* Ensure you have the following PHP Modules installed: mysql, mcrypt, gd.
* Run 'php composer.phar install' in the app\ directory to get CakePHP and check dependencies.
* Create a new database to store the application in. i.e. recipebook
* Edit Configuration DB Configuration Settings ./app/Config/database.php to match your database settings. 
* For File uploads:
    - mkdir ./app/webroot/files/recipe
    - sudo chown <your web group>.<your web user> ./app/webroot/files/recipe
* Launch the website and complete steps in wizard.