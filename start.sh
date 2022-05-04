#!/bin/sh
npm run watch &
php artisan websocket:serve
