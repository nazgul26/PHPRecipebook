
# Dockerized PHPRecipeBook

The Docker-related setup in this directory will facilitate deploying a
PHPRecipeBook release with Docker.

## Build an image

### Dockerfile

By using the included `Dockerfile`, you can build you own image based on an
exiting PHPRecipeBook release:
```
docker build --build-arg version=7.0 --tag user/phprecipebook:v7.0 .
```
The build process will download the specified release version of PHPRecipeBook
and use it to build the image.

If you don't specify the version, you get the default version defined in the
Dockerfile:
```
docker build --tag user/phprecipebook .
```


## Operational deployments with docker compose

TL;DR:

```
cp recipebook.env.example .env
docker compose --profile mysql up -d
```

The included Compose provides a ready-to-use setup for PHPRecipeBook deployments
with either a MySQL or PostgreSQL database.  The entire definition is included
in the `compose.yml` file; compose *profiles* are used to selectively enable the
required services.

You **must** enable either the `mysql` or the `pgsql` profile -- depending on whether
you want to run MySQL or PostgreSQL (else no database will be started). Optionally, you can also enable the `maintenance` profile to deploy an instance
of [adminer](https://www.adminer.org/en/).  Read on for instructions on how to
configure the application.


### Configuration

Configuration values are set through environment variables.  Copy the
`recipebook.env.example` file to `.env` and then customize it according to your
needs:

    cp recipebook.env.example .env

By default, the docker compose will load the `.env` file.  If you prefer using a
different name for your settings file, set its name in an environment variable
named `APP_ENV_FILE`.


### Starting the deployment

To deploy PHPRecipeBook with MySQL:

    docker compose --profile mysql up -d

To deploy PHPRecipeBook with PostgreSQL:

    docker compose --profile pgsql up -d


Adding `--profile maintenance` to the compose command line will add an
[adminer](https://www.adminer.org/en/) instance, on port 8001.


**Tip**:  You can also set the enabled profiles via the `COMPOSE_PROFILES`
environment variable. E.g.,
```
export COMPOSE_PROFILES=pgsql,maintenance
docker compose up -d
```

### On first start-up, seed the application

To seed a new instance with basic data elements run the following command in the
docker compose:

    docker compose run app-seeding

The CakePHP seeding process will be executed in a container, using the same
configuration as the main PHPRecipeBook application.

## Serving via HTTPS

The included Dockerfile and compose are configured to serve the application with
Apache, **only via HTTP on port 8080**.  If needed, you can add HTTPS support by
deploying a proxy in front of the PHPRecipeBook container; a simple and
user-friendly option could be <https://nginxproxymanager.com/>.


## Using compose to develop

The `compose.dev.yml` overrides the default configuration to mount the source
directory into the container.  Thus, you can run the following to have the
application source its code from the local working copy:
```
docker compose --profile pgsql,maintenance -f compose.yml -f compose.dev.yml up -d
```
**Note**: you'll have to first run `composer install` to install dependencies
into `./vendor`.


### Enabling debug mode

You can enable debug mode by setting the `DEBUG` environment variable:

    DEBUG=true docker compose up -d
