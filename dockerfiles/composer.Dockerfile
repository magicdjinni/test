FROM composer:latest

WORKDIR /var/www/protonix

RUN apk --no-cache add npm \
    && docker-php-ext-install pdo pdo_mysql

#   redis
RUN apk add --update --no-cache --virtual .build-dependencies ${PHPIZE_DEPS} \
        && pecl install redis \
        && docker-php-ext-enable redis \
        && pecl clear-cache \
        && apk del .build-dependencies