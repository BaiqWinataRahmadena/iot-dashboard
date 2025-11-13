#!/bin/sh
set -e
# Jalankan migrasi dan seeder
# Variabel DATABASE_URL dll akan disuntikkan oleh Render
echo "Running migrations and seeders..."
php artisan migrate --seed --force

# Nyalakan PHP-FPM di background
echo "Starting PHP-FPM..."
php-fpm -D

# Nyalakan Nginx di foreground
echo "Starting Nginx..."
nginx -g 'daemon off;'