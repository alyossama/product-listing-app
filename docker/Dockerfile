# Use the official PHP image with FPM
FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip

# Install required extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set the working directory
WORKDIR /var/www

# Download and install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

