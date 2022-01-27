#!/bin/sh
php artisan migrate
php artisan db:seed
php artisan passport:install
sh clear.sh
