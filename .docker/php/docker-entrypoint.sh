#!/usr/bin/env bash

set -ex

composer run post-autoload-dump --ansi --no-interaction
php artisan config:cache --ansi --no-interaction
php artisan route:cache --ansi --no-interaction
php artisan view:cache --ansi --no-interaction

php artisan migrate --force --ansi --no-interaction

php-fpm --fpm-config /php-fpm.conf
