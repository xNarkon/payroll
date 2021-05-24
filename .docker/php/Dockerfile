FROM php:8-cli

RUN apt-get update

# Missing PHP dependencies
RUN apt-get install -y \
        libzip-dev \
        zip \
        libicu-dev \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && docker-php-ext-install zip \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install bcmath \
  && docker-php-ext-install intl

# Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /app
