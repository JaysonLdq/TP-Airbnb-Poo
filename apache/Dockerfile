#utiliser une image de base PHP avec Apache 
FROM php:8.2-apache

# Activer le module mysql
RUN docker-php-ext-install mysqli pdo_mysql

RUN apt-get update && apt-get install -y \
    curl \
    unzip \
&& rm -rf /var/lib/apt/lists/*

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer