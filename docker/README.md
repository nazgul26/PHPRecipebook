
# Docker-compose application for PHPRecipebook

This docker-compose application starts two containers: a PostgreSQL server and
an Apache web server with mod-php, where PHPRecipebook runs.

## Minimal setup

1. Set the path on the host for the PostgreSQL data.  Edit the volume defined
	 for the `db` service in `docker-compose.yml`.

2. On the first run, enable PHPRecipebook's setup wizard.  Uncomment the
	 environment variable setting `PHPRECIPEBOOK_SETUP_MODE=TRUE`.  After you've
   created your admin user turn it back off and restart the application to enable
   regular operation.

## Usage

### Starting it

    docker-compose -f docker-compose.yml -d up

The default docker images will be pulled automatically from DockerHub.

If you pointed the database to an empty directory, a new PostgreSQL cluster will
be created.  If it doesn't already exist, the PHPRecipebook database (by default
called `recipebook`) will be created and initialized with the schema and basic
data.

### Accessing it

The application is under  `/recipebook` on port 8080 (e.g.,
[http://localhost:8080/recipebook](http://localhost:8080/recipebook).

### Stopping it

    docker-compose down


## Configuration

There are several environment variables that influence the operation of the
containers.  The database runs the [official PostgreSQL
image](https://hub.docker.com/_/postgres) so  all the settings documented there
apply.  

These are the main variables used by this docker-compose.

| Variable | Default value | Explanation |
+----------+---------------+-------------+
| POSTGRES_USER | recipebook | Database user. Must match PHPRECIPEBOOK_DB_LOGIN |
| POSTGRES_PASSWORD | recipebook | Password for database user.  Must match PHPRECIPEBOOK_DB_PASS |
| POSTGRES_DB | recipebook | Database name. Must match PHPRECIPEBOOK_DB_NAME |
| PHPRECIPEBOOK_DB_HOST | db | Name of database service |
| PHPRECIPEBOOK_DB_NAME | recipebook | Must match POSTGRES_DB |
| PHPRECIPEBOOK_DB_LOGIN | recipebook | Must match POSTGRES_USER |
| PHPRECIPEBOOK_DB_PASS | recipebook | Must match POSTGRES_PASSWORD |
| PHPRECIPEBOOK_SETUP_MODE | FALSE | Turn on PHPRecipebook setup mode |


## Notes

The database server currently runs as root, which means that the files created
in the database directory will be owned by root.  This issue may be addressed in
the future by letting the user specify the database process' user id.

