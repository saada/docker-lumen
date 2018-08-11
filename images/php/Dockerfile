FROM php:7.0-fpm
RUN apt-get update -y && apt-get install -y libmcrypt-dev

# lumen packages
RUN docker-php-ext-install mcrypt mbstring tokenizer mysqli pdo_mysql
RUN apt-get install -y zlib1g-dev libmemcached-dev
RUN pecl install memcached
RUN docker-php-ext-enable memcached
