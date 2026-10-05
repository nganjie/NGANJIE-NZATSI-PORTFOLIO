#!/bin/sh
# Prépare l'application avant de lancer la commande du conteneur (php-fpm, queue:work…).
set -e

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

php artisan optimize

exec "$@"
