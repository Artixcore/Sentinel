FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json ./
RUN composer install --no-interaction --prefer-dist --no-scripts
FROM php:8.4-cli-alpine
RUN apk add --no-cache libzip-dev curl-dev icu-dev && docker-php-ext-install pdo_mysql pcntl zip intl
COPY --from=vendor /app/vendor /var/www/html/vendor
WORKDIR /var/www/html
COPY . .
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache
EXPOSE 8000
