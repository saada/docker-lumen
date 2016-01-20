FROM php:fpm
RUN apt-get update && apt-get install -y libmcrypt-dev

# lumen packages
RUN apt-get install -y php5-memcached
RUN docker-php-ext-install mcrypt mbstring tokenizer mysqli
