#!/bin/sh
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan clear-compiled
composer dump-autoload
php artisan optimize:clear
