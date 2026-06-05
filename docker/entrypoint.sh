#!/bin/bash

php artisan optimize:clear
php artisan key:generate
php artisan config:cache
php artisan route:cache
/usr/bin/supervisord
