#!/usr/bin/env bash

set -ex

if [[ ! -f "storage/.exists" ]]
  then
    touch storage/.exists
    mkdir -p storage/app/public storage/framework/{cache/data,sessions,testing,views} storage/logs
  else
    php artisan down --ansi --no-interaction || true
fi

composer run post-autoload-dump --ansi --no-interaction

php artisan config:cache --ansi --no-interaction
php artisan route:cache --ansi --no-interaction || true
php artisan view:cache --ansi --no-interaction

php artisan migrate --force --ansi --no-interaction

php artisan up --ansi --no-interaction

trap : TERM INT
tail -f /dev/null & wait
