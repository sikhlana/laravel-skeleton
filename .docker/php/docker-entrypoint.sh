#!/usr/bin/env bash

set -ex

composer run post-autoload-dump --ansi --no-interaction
php artisan config:cache --ansi --no-interaction
php artisan route:cache --ansi --no-interaction || true
php artisan view:cache --ansi --no-interaction

php artisan migrate --force --ansi --no-interaction

php artisan scheduler:work --ansi --no-interaction
