#!/bin/sh
set -e

cd /var/www

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Cache config and routes for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisord.conf
