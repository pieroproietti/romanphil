FROM php:5.6.33-fpm-jessie

#RUN apt-get update \
#    && apt-get install php7.2-mysql -y


RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install json \
    && docker-php-ext-install mysqli
