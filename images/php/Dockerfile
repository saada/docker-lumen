FROM php:fpm
RUN apt-get update && apt-get install -y libmcrypt-dev

# lumen packages
RUN apt-get install -y php5-memcached \
    && docker-php-ext-install mcrypt mbstring tokenizer mysqli pdo_mysql \
    && apt-get install -y libz-dev libmemcached-dev \
    && pecl install memcached \
    && echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini
