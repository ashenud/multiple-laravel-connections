#!/bin/bash

# Set ownership to www-data for writable directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set permissions for storage directory
chmod -R 777 /var/www/html/storage

# Run composer update
composer update

# Run database migrations
php artisan migrate

# Start PHP-FPM
php-fpm
