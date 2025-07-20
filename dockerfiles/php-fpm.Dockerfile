FROM php:8.4.6-fpm-alpine

RUN mkdir -p /var/log/php-fpm

WORKDIR /var/www/protonix

#   composer install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#   core packages
RUN apk add --update --no-cache bash git nodejs yarn npm zlib-dev libpng-dev

#   docker extensions
RUN apk add --update --no-cache \
  && docker-php-ext-install pdo pdo_mysql

#   redis
RUN apk add --update --no-cache --virtual .build-dependencies ${PHPIZE_DEPS} \
        && pecl install redis \
        && docker-php-ext-enable redis \
        && pecl clear-cache \
        && apk del .build-dependencies

#RUN apk add --update --no-cache \
#  && docker-php-ext-install bcmath

#RUN apk add --update --no-cache \
#  && docker-php-ext-install opcache

#   xdebug install
RUN apk add --update --no-cache linux-headers autoconf
RUN apk add --update --no-cache --virtual .build-dependencies ${PHPIZE_DEPS} \
  && pecl install xdebug \
  && pecl clear-cache \
  && apk del .build-dependencies \
  && docker-php-ext-enable xdebug

#   apcu install
#RUN apk add --update --no-cache --virtual .build-dependencies ${PHPIZE_DEPS} \
#        && pecl install apcu \
#        && docker-php-ext-enable apcu \
#        && pecl clear-cache \
#        && apk del .build-dependencies

# www-data user
RUN getent passwd www-data || useradd -r -s /bin/false www-data