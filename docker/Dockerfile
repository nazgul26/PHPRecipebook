FROM php:8.1-apache

RUN apt-get update
RUN apt-get install -y libzip-dev libpng-dev libxml2-dev libonig-dev libcurl4-openssl-dev

RUN a2enmod rewrite
RUN docker-php-ext-install curl zip
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install gd xml 
RUN docker-php-ext-install intl mbstring 

ENTRYPOINT ["/var/www/html/docker/web-start.sh"]
