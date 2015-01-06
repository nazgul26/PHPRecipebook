PHPRecipebook
=============

PHP Recipe Book 5.0

This is a rewrite of PHPRecipeBook hosted on sourceforge to use Cake MVC.

Great progress has been made in 2014, about 1/2 way through re-write.  CakePHP is a so far a great platform for this project.  

Improvements I want to make along the way:
* AJAX Page loads (so less refreshes/data between clicks)
* Better/cleaner navigation
* HTML5 (bye bye tables)
* Better Meal Planner UI (Javascript Calendar)
* Integration with other vendors/services

And of course now that we are on GitHub contributions and collaboration should be must easier.  Look forward to anyone with some skills to jump in and keep this moving.

When the basics are working I will put up a Beta site for people to see what is coming.

There will be migration path from PHPRecipeBook 4.0


Installation Steps:

1. Run migration SQL Script
2. Edit Configuration DB Configuration Settings ./app/Config/database.php to match your database settings
3. For File uploads:
    mkdir ./app/webroot/files/recipe
    sudo chown www-data.www-data ./app/webroot/files/recipe
