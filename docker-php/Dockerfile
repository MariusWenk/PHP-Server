FROM php:7.4-fpm
# Workdir so far is /var/www/html
COPY Makefile .
COPY php.ini-development /usr/local/etc/php
COPY php.ini-production /usr/local/etc/php
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update -y && apt-get install -y --no-install-recommends apt-utils
RUN apt-get install -y make
RUN make standard
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/include/php
