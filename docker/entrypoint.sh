#!/bin/bash

php artisan optimize:clear
php artisan key:generate
php artisan config:cache
php artisan route:cache
/usr/bin/supervisord
supervisorctl reread
supervisorctl update all
supervisorctl restart all
sleep 86400
