FROM php:8

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install pdo pdo_mysql mysqli
