# -----------------------------
# Stage 1: Composer dependencies
# -----------------------------
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-progress --prefer-dist

# -----------------------------
# Stage 2: PHP-FPM Application
# -----------------------------
FROM php:8.3-fpm AS app

# System dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Copy application
WORKDIR /var/www/html
COPY . .
COPY --from=vendor /app/vendor ./vendor

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
