#!/bin/bash
set -x

echo "Press [CTRL+C] to stop.."
sleep 5
    echo "My second and third argument is $2 & $3"
    exec "php-fpm" -D
    php /usr/share/nginx/www/code/artisan horizon
