<h1>PHPRecipebook 5.0</h1>
=============

PHPRecipeBook is a cookbook and meal planning software.

<a href="https://warm-beyond-24755.herokuapp.com/">Demo site</a> (Create your own account)

Demo Videos:
* <a href="https://youtu.be/xNUBANz2aVI">Adding A Recipe</a>
* <a href="https://youtu.be/xZZJI407aSs">Meal Planning</a>
* <a href="https://youtu.be/zWtfNrYJJRk">Shopping</a>

Features:
* AJAX Page loads (so less refreshes/data between clicks)
* Clean navigation
* Meal Planner
* Setup wizard is included and a complete migration script.
* Integration PrestoFresh online grocery, ability to extend to other vendors.
* Enhanced Password security encryption
* More databases supported because of CakePHP abstraction.
* Built using CakePHP

Now that we are on GitHub contributions and collaboration should be must easier.  
Look forward to anyone with some skills to jump in and keep this moving.

<h2>Installation</h2>
<p>
There are two ways to install PHPRecipebook. The first option is to use Git to get the code.  This option will allow for very easy upgrades but a little more 
upfront effort. The second option is to simply download the tar.gz file and extract.  This option is very easy upfront but upgrades will require 
more effort copying files around.
</p>

<h3>Git Install Option</h3>
* Clone 'PHPRecipebook' repository.
* Get PHP Composer installed. https://getcomposer.org/download/.  Composer is used to manage dependencies and make upgrading CakePHP easier.
* Run 'php composer.phar install' in the application directory to get CakePHP and check dependencies.
* To upgrade later simply run 'git pull'. Resolve merge conflicts if needed.

<h3>Download Install Option</h3>
* Download latest release from https://github.com/nazgul26/PHPRecipebook/releases
* Extract files to your web folder.

<hr/>
<h4>Setup Directions for all</h4>
* Ensure you have the following PHP Modules installed: mcrypt, gd. And mysql, pgsql or your DB.
* Create a new database to store the application in. i.e. recipebook
* Edit Configuration DB Configuration Settings <app dir>/Config/database.php to match your database settings. 
* Edit <app dir/Config/core.php and set your language if other than English.  Go to translations below if not available.
* Make the <app install dir>/temp folder in the application writable for web user.  example:
    - sudo chown -R apache.apache tmp
  If you don't make <app install dir>/tmp writable by the web user the app will not run!
* For File uploads:
    - mkdir <app install dir>/webroot/files/recipe
    - sudo chown <your web group>.<your web user> <app install dir>/webroot/files/recipe
* Launch the website and complete steps in wizard.

<h2>Upgrades in 5.x Series</h2>
Between releases you can update your database by running 
* Get latest release (git or Release download).
* ./Console/cake schema update 
* removing all files from ./tmp/cache/models

<h2>Heroku Deployment</h2>
<hr/>
* Clone PHPRecipebook to your computer.
* Create an account on heroku and step through their tutorial if you have never done so before.
* In the PHPRecipebook local repo run: heroku create
* Run: heroku addons:add heroku-postgresql:hobby-dev
    - More info at: https://devcenter.heroku.com/articles/heroku-postgresql
* edit Config/database.php and put in commented out heroku config, remove block for normal db config.
* edit .gitignore and remove 'Config/database.php' line to allow 
* commit changes (git)
* git push heroku master
* heroku open
* heroku run bash
    - (then follow setup directions for): ./Console/cake schema create
* modify core.php and change setup to false. Commit.
    - git push heroku master
* reload web page and then login with your password that you set during the setup of the app.

<h2>Troubleshooting</h2>
* App does not load:
  - Solution 1: Check the temp directory is writable by the web user.  Try giving world r/w to rule out this (put back after done).
  - Solution 2: Your webserver does not support url rewriting.  Follow the directions http://book.cakephp.org/2.0/en/development/configuration.html#cakephp-core-configuration to change app to not use rewriting.
* You get this error: Warning: include(/<some path>/Vendor/cakephp/cakephp/lib/Cake/Error/ErrorHandler.php): failed to open stream: 
  - Solution: Clear the ./tmp/cache/models, ./tmp/cache/persistent directories.  These folders keep path info in them so if the path the app runs from changes the cache has to be cleared.
* Page loads but is missing images.
  - Solution: Check your apache configuration to ensure it allows overrides and mod_rewrite is installed.  The .htaccess files are not properly working and rewriting the URL.  You know this is working when the images load
 on the login page.

<h2>Translations</h2>
<hr/>
If your local language is not yet translated I can run it up against Google Translate API.  Please star the project (show you care) and submit an 'Issue' to translate.
<br/>
If you are interested in performing a translation/corrections then here are some basic steps to follow:
<p>
* Install Poedit (http://poedit.net/).  This is an Open Source tool that will help in translations. Hint for Ubuntu installs -  sudo apt-get install poedit
* Open the <app dir>/Locale/default.pot in Poedit and translate
* When done save in Locale\<lang code>\LC_MESSAGES\default.po
</p>
##Currently Supported Languages / Translation Code
* Chinese - zho
* Danish - dan
* Dutch - nld
* English - eng
* Estonian - est
* French - fra
* German - deu
* Hungarian - hun
* Italian - ita
* Japanese - jpn
* Korean - kor
* Norwegian - nor
* Portuguese - por
* Turkish - tur
* Serbian - srp
* Spanish - spa
* Swedish - swe


