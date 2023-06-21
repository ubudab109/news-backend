FROM php:8.1-apache

RUN apt update && apt install -y zlib1g-dev g++ libicu-dev zip libzip-dev zip libpq-dev \
    && docker-php-ext-install intl opcache pdo pgsql pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

WORKDIR /var/www/laravel_docker

RUN a2enmod rewrite
RUN service apache2 restart

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer