#!/bin/sh
# Prépare l'application avant de lancer la commande du conteneur (php-fpm, queue:work…).
set -e

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    # La base de données est un conteneur externe : on l'attend (2 minutes au plus).
    attempt=1
    until php artisan migrate --force; do
        if [ "$attempt" -ge 30 ]; then
            echo "Base de données injoignable (DB_HOST=${DB_HOST:-?}). Vérifiez .env et le réseau mikrotikreseau." >&2
            exit 1
        fi
        echo "Base de données pas encore prête, nouvel essai dans 4 s ($attempt/30)…" >&2
        attempt=$((attempt + 1))
        sleep 4
    done
fi

php artisan optimize

exec "$@"
