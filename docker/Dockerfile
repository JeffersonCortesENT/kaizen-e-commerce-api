# Use a specific PHP version with Apache for consistency
FROM php:8.2-apache

# Enable Apache's mod_rewrite for Laravel-friendly URLs
RUN a2enmod rewrite

# Update package list
RUN apt-get update

# Install dependencies for GD (image processing)
RUN apt-get install -y libfreetype6-dev libjpeg-dev libpng-dev \
  && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
  && docker-php-ext-install gd

# Install dependencies for Intl (internationalization support)
RUN apt-get install -y libicu-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl

# Install dependencies for Zip support
RUN apt-get install -y zlib1g-dev libzip-dev \
  && docker-php-ext-install zip

# Install dependencies for RabbitMQ (AMQP support)
RUN apt-get install -y librabbitmq-dev \
  && pecl install amqp-2.1.2 \
  && docker-php-ext-enable amqp

# Install dependencies for SSH support
RUN apt-get install -y libssh-dev

# Install additional PHP extensions
RUN docker-php-ext-install bcmath exif opcache pdo pdo_mysql

# Install APCu for caching
RUN pecl install apcu-5.1.21 \
  && docker-php-ext-enable apcu

# Install Xdebug for debugging
RUN pecl install xdebug-3.2.2 \
  && docker-php-ext-enable xdebug

# Install Git, Unzip, and ACL for various operations
RUN apt-get install -y git unzip acl

# Install Composer with a fixed version for consistency
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.7.2

# Create Laravel user (Fixed UID for Windows WSL 2)
RUN useradd -G www-data,root -u 1000 -d /home/laravel laravel

# Set the working directory inside the container
WORKDIR /var/www/api.kaizen-e-commerce

# Ensure Laravel writable directories exist before setting permissions
RUN mkdir -p /var/www/api.kaizen-e-commerce/storage /var/www/api.kaizen-e-commerce/bootstrap/cache \
  && chown -R www-data:www-data /var/www/api.kaizen-e-commerce/storage /var/www/api.kaizen-e-commerce/bootstrap/cache \
  && chmod -R 777 /var/www/api.kaizen-e-commerce/storage /var/www/api.kaizen-e-commerce/bootstrap/cache

# Keep running as root (Windows workaround)
USER root
