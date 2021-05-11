FROM php:7.4-cli-alpine

ENV COMPOSER_HOME /tmp

RUN apk add --no-cache \
    autoconf \
    g++ \
    make

RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN apk add --no-cache icu-dev \
    && docker-php-ext-install intl

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY --from=composer:2.0.8 /usr/bin/composer /usr/bin/composer
