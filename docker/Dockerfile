
# Container must be started as user www-data.
# Seeding application data to be done manually, if required (i.e. fresh
# installation)


FROM php:8.2-apache as base

ENV DEBIAN_FRONTEND noninteractive


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

FROM base AS recipebook

ARG version=6.8
ARG cv=0.1

ENV RecipebookRoot=/var/www/html/

RUN \
    cd /tmp \
 && curl --fail --location --output /tmp/phprecipebook.tar.gz https://github.com/nazgul26/PHPRecipebook/releases/download/${version}/phprecipebook${version}.tgz   \
 && mkdir -p ${RecipebookRoot} \
 && tar -C ${RecipebookRoot} --strip-components=1 -xzpf /tmp/phprecipebook.tar.gz \
 && rm /tmp/phprecipebook.tar.gz \
    "${RecipebookRoot}/docker/Dockerfile" \
    "${RecipebookRoot}/docker/docker-compose.yml" \
    "${RecipebookRoot}/docker/docker-vars.env"


# Configure Apache to serve only HTTP via port 8080.
# HTTPS can be more easily configured with a dedicated proxy, which can integrate logic for certificate management.
COPY apache2/ports.conf /etc/apache2/
RUN a2enmod rewrite

RUN sed -i -e '/VirtualHost/s/:80\>/:8080/' /etc/apache2/sites-available/000-default.conf \
  && sed -i -e '/Comment out/,/END/s/^/#/' "${RecipebookRoot}/.htaccess"

EXPOSE 8080

COPY web-start.sh ${RecipebookRoot}/docker/web-start.sh

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
RUN sed -i 's|use Cake\\Auth\\DefaultPasswordHasher;|use Authentication\\PasswordHasher\\DefaultPasswordHasher;|' \
    "${RecipebookRoot}/config/Seeds/UsersSeed.php"
