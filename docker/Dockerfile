FROM php:8-apache

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN a2enmod rewrite
