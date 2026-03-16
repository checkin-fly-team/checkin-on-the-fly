#!/bin/sh

cd /var/www

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
  echo "WARNING: APP_KEY is not set, generating one..."
  php artisan key:generate --force
fi

# Run migrations (non-fatal — app still starts if DB is unavailable)
echo "Running migrations..."
php artisan migrate --force || echo "WARNING: Migrations failed, continuing anyway..."

# Cache config and routes for production (non-fatal)
php artisan config:cache || echo "WARNING: config:cache failed"
php artisan route:cache || echo "WARNING: route:cache failed"
php artisan view:cache || echo "WARNING: view:cache failed"

# Start supervisor (nginx + php-fpm)
echo "Starting services..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
