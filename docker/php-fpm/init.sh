#!/bin/bash

# Set ownership to www-data for writable directories
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Set permissions for storage directory
chmod -R 777 /var/www/storage

# Run composer update
composer update

# Run database migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Start PHP-FPM
php-fpm
