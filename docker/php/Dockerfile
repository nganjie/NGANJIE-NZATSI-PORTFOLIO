# syntax=docker/dockerfile:1

# ---------------------------------------------------------------------------
# Base PHP-FPM commune au développement et à la production
# ---------------------------------------------------------------------------
FROM php:8.4-fpm-alpine AS base

RUN apk add --no-cache \
        bash icu-libs libpq libzip libpng libjpeg-turbo libwebp freetype \
        jpegoptim optipng pngquant gifsicle libwebp-tools fcgi \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
        icu-dev libpq-dev libzip-dev libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev linux-headers \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install -j"$(nproc)" bcmath exif gd intl opcache pcntl pdo_pgsql zip \
    && apk del .build-deps

COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/php/fpm.conf /usr/local/etc/php-fpm.d/zz-app.conf
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ---------------------------------------------------------------------------
# Développement : le code est monté en volume, Composer et Node disponibles
# ---------------------------------------------------------------------------
FROM base AS dev

RUN apk add --no-cache nodejs npm git \
    && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

ARG UID=1000
ARG GID=1000
RUN apk add --no-cache shadow \
    && usermod -u "${UID}" www-data && groupmod -g "${GID}" www-data

USER www-data

# ---------------------------------------------------------------------------
# Dépendances PHP de production
# ---------------------------------------------------------------------------
FROM base AS vendor

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader --prefer-dist

# ---------------------------------------------------------------------------
# Construction des fichiers front (Vite)
# ---------------------------------------------------------------------------
FROM node:22-alpine AS assets

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts
COPY vite.config.js ./
COPY resources ./resources
COPY --from=vendor /var/www/html/vendor/livewire ./vendor/livewire
RUN npm run build

# ---------------------------------------------------------------------------
# Production : image autonome, code et fichiers construits inclus
# ---------------------------------------------------------------------------
FROM base AS prod

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY docker/php/opcache-prod.ini /usr/local/etc/php/conf.d/zz-opcache.ini

COPY --from=vendor /var/www/html/vendor ./vendor
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --no-dev --optimize --classmap-authoritative \
    && rm -rf docker tests node_modules .env \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs storage/app/public \
    && ln -sfn ../storage/app/public public/storage \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

USER www-data

HEALTHCHECK --interval=30s --timeout=5s --retries=3 \
    CMD SCRIPT_NAME=/ping SCRIPT_FILENAME=/ping REQUEST_METHOD=GET cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1

ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]

# ---------------------------------------------------------------------------
# Serveur web de production : Caddy (HTTPS automatique) + fichiers publics
# ---------------------------------------------------------------------------
FROM caddy:2-alpine AS web

COPY docker/caddy/Caddyfile /etc/caddy/Caddyfile
COPY --from=prod /var/www/html/public /var/www/html/public
RUN rm -f /var/www/html/public/storage \
    && ln -s /var/www/html/storage/app/public /var/www/html/public/storage
