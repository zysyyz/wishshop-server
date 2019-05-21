#!/usr/bin/env bash

php artisan swagger-lume:generate
php -S 127.0.0.1:8000 -t public
# php -S 192.168.1.186:8000 -t public