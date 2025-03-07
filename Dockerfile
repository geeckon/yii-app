FROM php:8.3-fpm
RUN apt update -y && apt install -y openssl zip unzip git mariadb-client
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
