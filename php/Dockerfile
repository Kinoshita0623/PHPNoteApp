FROM php:7.4-fpm
COPY php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y vim zip unzip

RUN apt-get install -y libpq-dev \
    libonig-dev \ 
    && docker-php-ext-install pdo pdo_mysql