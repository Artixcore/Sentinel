#!/usr/bin/env bash
set -Eeuo pipefail

APP_DIR="/opt/sentinel"
cd "$APP_DIR"

git pull --ff-only origin master
docker compose -f docker-compose.prod.yml build --pull
docker compose -f docker-compose.prod.yml up -d mysql redis
docker compose -f docker-compose.prod.yml run --rm api php artisan migrate --force
docker compose -f docker-compose.prod.yml up -d --remove-orphans
docker compose -f docker-compose.prod.yml exec -T api php artisan optimize
docker compose -f docker-compose.prod.yml exec -T worker php artisan queue:restart
docker image prune -f
docker compose -f docker-compose.prod.yml ps
