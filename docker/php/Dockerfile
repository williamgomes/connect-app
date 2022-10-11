FROM php:8.1-fpm-alpine3.14 as base

RUN apk add --no-cache --no-progress --virtual BUILD_DEPS_PHP_GMP gmp-dev \
    && apk add --no-cache --no-progress gmp \
    && docker-php-ext-install gmp
RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl

RUN apk add libxml2-dev autoconf gcc make g++ libzip-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install exif
RUN pecl install mailparse \
    && docker-php-ext-enable mailparse
RUN docker-php-ext-install soap \
    && docker-php-ext-install zip

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

FROM base as dev

RUN apk update && apk add \
    git \
    curl \
    zip \
    unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

FROM base as coverage

RUN pecl install pcov \
    && docker-php-ext-enable pcov

COPY ./docker/php/pcov.ini /usr/local/etc/php/conf.d/pcov.ini
