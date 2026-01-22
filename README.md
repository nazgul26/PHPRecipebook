# PHPRecipebook 6.x
---

PHPRecipeBook is a cookbook and meal planning software.

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
* Built using CakePHP v4

### Currently Supported Languages / Translation Code
* Chinese - zh
* Danish - da
* Dutch - nl
* English - en
* Estonian - et
* French - fr
* German - de
* Hungarian - hu
* Italian - it
* Japanese - jp
* Korean - ko
* Norwegian - no
* Portuguese - pt
* Turkish - tr
* Serbian - sr
* Spanish - sp
* Swedish - sv

# Docker Deployment

Docker is a fast way to try out PHPRecipebook.

+ Install and Configure Docker.  Ensure Docker is running.

+ Download the latest release of PHPRecipebook and extract to a location on your computer.  The parent folder you extract to will be the root of your install.  

+ Create a configuration file phprecipebook/config/.env

with contents (modify to fit your needs):

```
export APP_NAME="PHPRecipeBook"
export ALLOW_PUBLIC_ACCOUNT_CREATION = "false"
export PRIVATE_COLLECTION = "false"
export DEBUG="false"
export APP_ENCODING="UTF-8"
export APP_DEFAULT_LOCALE="en"
export APP_DEFAULT_TIMEZONE="UTC"
export SECURITY_SALT="------ CHANGE TO RANDOM STRING ----------------------------"
export DATABASE_URL="mysql://phpuser:RBAdm1n$@db/phprecipebook?encoding=utf8&timezone=UTC&cacheMetadata=true&quoteIdentifiers=false&persistent=false"
export EMAIL_TRANSPORT_DEFAULT_URL="smtp://my@gmail.com:secret@smtp.gmail.com:587?tls=true"

```

Change the MySQL default password (RBAdm1n$) if your server/ports are exposed to the internet!  Update in the above .env and in \docker\docker-vars.env file.

+ Build Web Image - 
  - cd docker
  - docker build -t phprecipebook-web:v6 .

+ Compose / Start App - 
  - docker compose up

+ Visit the app at http://localhost:8080, login with admin/passwd.

+ When upgrading PHPRecipebook you should save the .env file AND ensure a file called 'CONTAINER_FIRST_STARTUP' exists like it does prior to code update.  This will prevent Seed data from being attempted to be written twice!

Debugging Notes:  
- Change DEBUG to 'true' if app does not run
- Check logs in output of Docker
- Check log in /var/www/html/logs on php docker container.
- Check the SQL using PHPMyAdmin at http://localhost:8001 , login with phpuser/RBAdm1n$


# Heroku Deployment

The fastest way to get running is using a provider like Heroku.

NOTE: Heroku requires paid accounts for all access now.

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
    + PHP 7 (or higher) with modules:
      php-xml (sudo apt install php-xml)
      php-intl
      php-mbstring
      php-curl
      php-zip

    + MySQL with a local db user created.

Create a configuration file config/.env

with contents (modify to fit your needs):

```
export APP_NAME="PHPRecipeBook"
export ALLOW_PUBLIC_ACCOUNT_CREATION = "false"
export PRIVATE_COLLECTION = "false"
export DEBUG="false"
export APP_ENCODING="UTF-8"
export APP_DEFAULT_LOCALE="en"
export APP_DEFAULT_TIMEZONE="UTC"
export SECURITY_SALT="------ CHANGE TO RANDOM STRING ----------------------------"
export DATABASE_URL="mysql://user:password@localhost/phprecipebook?encoding=utf8&timezone=UTC&cacheMetadata=true&quoteIdentifiers=false&persistent=false"
export EMAIL_TRANSPORT_DEFAULT_URL="smtp://my@gmail.com:secret@smtp.gmail.com:587?tls=true"
export EMAIL_FROM_ADDRESS="noreply@phprecipebook.com"
export EMAIL_FROM_NAME="PHP RecipeBook"

```

Enable mod_write in Apache:

  sudo a2enmod rewrite
  (edit apache site config to allow...)
  sudo systemctl restart apache2

  Good tutorial for Ubuntu - https://www.digitalocean.com/community/tutorials/how-to-rewrite-urls-with-mod_rewrite-for-apache-on-ubuntu-22-04
  
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

### Send Dinner Reminders Job

PHPRecipebook includes a command that sends email reminders to users about their dinner plans for the next day. Users must have dinner reminders enabled in their profile and have an email address configured to receive these emails.

**Prerequisites:**
- Email must be configured in your `.env` file (EMAIL_TRANSPORT_DEFAULT_URL).  
- Email FROM_ADDRESS_EMAIL should also be properly configured to be in the domain your email server controls. 
- The APP_DEFAULT_TIMEZONE should be set correctly for your location

**Running manually:**

```bash
cd /var/www/html/phprecipebook
bin/cake send_dinner_reminders
```

To preview what emails would be sent without actually sending them:

```bash
bin/cake send_dinner_reminders --dry-run
```

**Setting up a cron job:**

To send reminders automatically each evening, add a cron job. For example, to run at 5:00 PM daily:

```bash
crontab -e
```

Add the following line (adjust the path and time as needed):

```
0 17 * * * cd /var/www/html/phprecipebook && bin/cake send_dinner_reminders >> /var/log/dinner_reminders.log 2>&1
```

This will run the job daily at 5:00 PM and log output to `/var/log/dinner_reminders.log`.



