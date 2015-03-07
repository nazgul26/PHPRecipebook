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

<h2>Fresh Installation</h2>
<hr/>
* Ensure you have the following PHP Modules installed: mysql, mcrypt, gd.
* Create a new database to store the application in. i.e. recipebook
* Edit Configuration DB Configuration Settings ./Config/database.php to match your database settings. 
* Make the ./temp folder in the application writable for web user.  example:
    - sudo chown -R apache.apache tmp
  If you don't make <app install dir>/tmp writable by the web user the app will not run!
* For File uploads:
    - mkdir ./webroot/files/recipe
    - sudo chown <your web group>.<your web user> ./webroot/files/recipe
* Launch the website and complete steps in wizard.

<h2>Troubleshooting</h2>
* App does not load:
  - Solution 1: Check the temp directory is writable by the web user.  Try giving world r/w to rule out this (put back after done).
  - Solution 2: Your webserver does not support url rewriting.  Follow the directions http://book.cakephp.org/2.0/en/development/configuration.html#cakephp-core-configuration to change app to not use rewriting.
* You get this error: Warning: include(/<some path>/Vendor/cakephp/cakephp/lib/Cake/Error/ErrorHandler.php): failed to open stream: 
  - Solution: Clear the ./tmp/cache/models, ./tmp/cache/persistent directories.  These folders keep path info in them so if the path the app runs from changes the cache has to be cleared.

<h2>Developer Requirements</h2>
* Get PHP Composer installed. https://getcomposer.org/download/.  Composer is used to manage dependencies and make upgrading CakePHP easier.
* Run 'php composer.phar install' in the application directory to get CakePHP and check dependencies.