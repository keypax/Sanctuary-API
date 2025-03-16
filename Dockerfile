FROM php:8.4-fpm-alpine

RUN apk add --no-cache --update \
    autoconf \
    gcc \
    g++ \
    make \
    icu-dev \
    libzip-dev \
    postgresql-dev \
    git \
    unzip \
    linux-headers \
  && docker-php-ext-install intl pdo_pgsql zip opcache

RUN pecl install xdebug
COPY docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN pecl install redis \
  && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN sed -i 's/^listen = .*/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf

WORKDIR /app
COPY . /app