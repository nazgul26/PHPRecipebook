FROM php:7.0-apache

ENV version 5.1.4

ENV DEBIAN_FRONTEND noninteractive
RUN \
  apt-get update && \
  apt-get install -y wget mysql-client libmysqlclient-dev --no-install-recommends && \
  docker-php-ext-install pdo pdo_mysql && \
  a2enmod rewrite && \
  apt-get -y autoremove && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
  cd /tmp && \
  wget https://github.com/nazgul26/PHPRecipebook/releases/download/5.1.4/phprecipebook-${version}.tar.gz  --output-document="/tmp/phprecipebook-${version}.tar.gz"

RUN \
  cd /tmp && tar xf /tmp/phprecipebook-${version}.tar.gz && \
  mv /tmp/phprecipebook/* /var/www/html && \
  mv /tmp/phprecipebook/.htaccess /var/www/html

COPY database.php /var/www/html/Config/database.php

WORKDIR /var/www/html

#USER www-data
