#!/bin/bash

chmod 777 -R /var/www/html/storage
chmod 777 -R /var/www/html/bootstrap/cache

if [ ! -d "/var/www/html/vendor" ]; then
    echo "[App] Update composer"
    php composer update
fi

if [ ! -f "/var/www/html/.env" ]; then
    echo "[App] Copy environment"
    cp .env.example .env

    echo "[App] Key generation"
    php artisan key:generate
fi

echo "Application is running"

/usr/sbin/apache2ctl -D FOREGROUND
