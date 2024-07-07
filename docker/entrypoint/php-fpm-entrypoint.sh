#!/bin/bash

COMPOSER_MEMORY_LIMIT=-1 composer install

php artisan migrate
php artisan key:generate
php artisan cache:clear
php artisan config:cache

# Start php-fpm service (running a service also prevents container from exiting)
php-fpm