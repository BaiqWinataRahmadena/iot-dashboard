# File: Dockerfile (di root proyek)

# --- Stage 1: Build dependensi PHP (Composer) ---
FROM composer:2 AS composer
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# --- Stage 2: Build aset Frontend (Vite/NPM) ---
FROM node:18 AS node
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Stage 3: Final Image (PHP-FPM + Nginx) ---
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Instal dependensi sistem: Nginx, Git, dan ekstensi PHP
# Kita butuh pdo_pgsql untuk database Render
RUN apk add --no-cache \
    nginx \
    zip \
    unzip \
    git \
    postgresql-dev  # <-- Pustaka sistem yang diperlukan untuk pdo_pgsql

# Instal ekstensi PHP (pdo dan pdo_pgsql) menggunakan helper Docker
RUN docker-php-ext-install pdo pdo_pgsql

# Salin file konfigurasi Nginx dari folder .docker
COPY .docker/nginx.conf /etc/nginx/http.d/default.conf

# Salin dependensi Composer dari Stage 1
COPY --from=composer /app/vendor /var/www/html/vendor

# Salin aset frontend yang sudah di-build dari Stage 2
COPY --from=node /app/public/build /var/www/html/public/build

# Salin semua sisa kode aplikasi
COPY . .

# Salin skrip start dari folder .docker
COPY .docker/start.sh /start.sh

# Atur izin...
RUN chmod +x /start.sh
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Atur port yang akan diekspos oleh Nginx
EXPOSE 8080

# Jalankan skrip start saat container dinyalakan
CMD ["/start.sh"]