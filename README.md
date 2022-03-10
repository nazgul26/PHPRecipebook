# PHPRecipebook 6.0
---

PHPRecipeBook is a cookbook and meal planning software.

<a href="https://warm-beyond-24755.herokuapp.com/">Demo site</a> (Create your own account)

Demo Videos:
* <a href="https://youtu.be/xNUBANz2aVI">Adding A Recipe</a>
* <a href="https://youtu.be/xZZJI407aSs">Meal Planning</a>
* <a href="https://youtu.be/zWtfNrYJJRk">Shopping</a>

Features:
* Recipe edit/create/view.
* Meal Planner
* Restaurant List
* Shopping Lists
* Multi-User Support
* Built using CakePHP v3

# Heroku Deployment

The fastest way to get running is using a provider like Heroku.

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

+ Create a Heroku Account if you don't already have one
+ Set the variables when prompted before deploying.
+ Configure the 'Deploy' tab in Heroku to integrate with GitHub for updates - https://devcenter.heroku.com/articles/github-integration

The default login of the application is --

User:admin
Password: passwd
**CHANGE THE PASSWORD** of your application after login.


That is it.  You can then start adding ingredients and recipes.

## Server Install

The second and very common way to run a PHP application is paying for hosting a traditional web hosting provider.  This would provide a fixed cost each month to run your application.  Most likely the basic level of hosting on many providers will be sufficient for many years of growing your business.  We would recommend SiteGround (https://www.siteground.com/) if you don't have a preference to start with.

To start you will need to have:
    + PHP 7 (or higher) with ext-dom (sudo apt install php-xml)
    + MySQL with a local db user created.

Create a configuration file config/.env

with contents (modify to fit your needs):

```

export APP_NAME="PHPRecipeBook"
export ALLOW_PUBLIC_ACCOUNT_CREATION = "false"
export PRIVATE_COLLECTION = "false"
export DEBUG="false"
export APP_ENCODING="UTF-8"
export APP_DEFAULT_LOCALE="en_US"
export APP_DEFAULT_TIMEZONE="UTC"
export SECURITY_SALT="------ CHANGE TO RANDOM STRING ----------------------------"
export DATABASE_URL="mysql://dbname:password@localhost/phprecipebook?encoding=utf8&timezone=UTC&cacheMetadata=true&quoteIdentifiers=false&persistent=false"
export EMAIL_TRANSPORT_DEFAULT_URL="smtp://my@gmail.com:secret@smtp.gmail.com:587?tls=true"

```
### Directory Permissions

* Make the <app install dir>/temp and logs folder in the application writable for web user.  example:
    - sudo chown -R www-data.www-data tmp
    - sudo chown -R www-data.www-data logs

  If you don't make <app install dir>/tmp writable by the web user the app will not run!

### Database Setup

Create your mysql/postgresql Db.  For example 'phprecipebook'.  Then run:

./bin/deploy.sh 

From the directory that the app was extracted to.  If you get any db errors double check you .env values.

### Local Development

Edit the ./.htaccess file and comment out the https redirect lines.


