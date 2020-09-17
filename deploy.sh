#!/usr/bin/env bash

set -ex

if [[ -n "$1" ]]
  then
    git fetch
    git checkout "$1"
  else
    git pull
fi

git log --pretty="%h" -n1 HEAD > release

docker-compose build --parallel
docker-compose run -d --force-recreate

docker system prune --all --force
