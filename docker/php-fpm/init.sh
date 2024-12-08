#!/bin/bash

# Set ownership to www-data for writable directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set permissions for storage directory
chmod -R 777 /var/www/html/storage

# Allows Git to safely operate within the specified directory, `/var/www/html`.
# This is useful for avoiding 'fatal: unsafe directory' errors when working with Git in Docker or other non-standard environments.
git config --global --add safe.directory /var/www/html

# Run composer update
composer update

# Run database migrations
php artisan migrate

# Start PHP-FPM
php-fpm
