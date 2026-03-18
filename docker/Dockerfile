
# Container must be started as user www-data.
# Seeding application data to be done manually, if required (i.e. fresh
# installation)

FROM php:8.2-apache AS base

ENV DEBIAN_FRONTEND=noninteractive


RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    libzip5 \
    libzip-dev \
    libpng16-16t64 \
    libpng-dev \
    libonig5 \
    libonig-dev \
    libicu76 \
    libicu-dev \
    libpq5 \
    libpq-dev \
 && docker-php-ext-install \
      zip \
      mysqli pdo_mysql pdo_pgsql \
      gd intl \
 && apt-get remove -y --purge --auto-remove \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libicu-dev \
    libpq-dev \
 && apt-get clean -y && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Use the default production configuration provided with the base image
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Configure Apache to serve only HTTP via port 8080.
# HTTPS can be more easily configured with a dedicated proxy, which can integrate logic for certificate management.
RUN sed -i -e '/VirtualHost/s/:80\>/:8080/' /etc/apache2/sites-available/000-default.conf \
 && echo 'Listen 8080' > /etc/apache2/ports.conf
EXPOSE 8080

RUN a2enmod rewrite

FROM base AS recipebook-release

ARG version=7.0

ENV RecipebookRoot=/var/www/html/

# Retrieve the specified release archive and install it
RUN \
    cd /tmp \
 && curl --fail --location --output /tmp/phprecipebook.tar.gz https://github.com/nazgul26/PHPRecipebook/releases/download/${version}/phprecipebook${version}.tgz   \
 && mkdir -p ${RecipebookRoot} \
 && tar -C ${RecipebookRoot} --strip-components=1 -xzpf /tmp/phprecipebook.tar.gz \
 && rm -f /tmp/phprecipebook.tar.gz \
    ${RecipebookRoot}/docker/[Dd]ocker* \
    ${RecipebookRoot}/docker/compose.* \
    ${RecipebookRoot}/docker/*.env

# Disable redirection to https in .htaccess
RUN sed -i -e '/Comment out/,/END/s/^/#/' "${RecipebookRoot}/.htaccess"

COPY web-start.sh ${RecipebookRoot}/docker/web-start.sh

# set directory and file ownershipt and permissions
RUN \
    chown -R root:root ${RecipebookRoot} \
 && chmod -R a-w ${RecipebookRoot} \
 && chown -R www-data:www-data ${RecipebookRoot}/tmp \
 && chown -R www-data:www-data ${RecipebookRoot}/logs \
 && chmod -R u+rw ${RecipebookRoot}/tmp \
 && find ${RecipebookRoot}/tmp ${RecipebookRoot}/logs -type d -print0 | xargs -0 chmod u+rwx \
 && chmod u+x ${RecipebookRoot}/docker/web-start.sh

HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8080/ || exit 1


ENTRYPOINT ["/var/www/html/docker/web-start.sh"]

# Temporary work-around for issue #171.
RUN sed -i 's|use Cake\\Auth\\DefaultPasswordHasher;|use Authentication\\PasswordHasher\\DefaultPasswordHasher;|' \
    "${RecipebookRoot}/config/Seeds/UsersSeed.php"


USER www-data:www-data
