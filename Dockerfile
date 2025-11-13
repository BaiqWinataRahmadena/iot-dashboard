# File: Dockerfile (Ganti seluruh isinya dengan ini)

# --- Stage 1: Build dependensi PHP (Composer) ---
# Di stage ini, kita salin SEMUA file agar 'artisan' ada saat 'composer install'
FROM composer:2 AS composer
WORKDIR /app
COPY . .
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
# Kita TIDAK menggunakan --no-scripts, sehingga artisan package:discover berjalan di sini

# --- Stage 2: Build aset Frontend (Vite/NPM) ---
FROM node:20 AS node 
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Stage 3: Final Image (PHP-FPM + Nginx) ---
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Instal dependensi sistem (termasuk PUSTAKA untuk PostgreSQL)
RUN apk add --no-cache \
    nginx \
    zip \
    unzip \
    git \
    postgresql-dev

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

# DIHAPUS: Kita tidak perlu menjalankan composer run-script di sini lagi
# karena sudah dijalankan di Stage 1

# Atur izin...
RUN chmod +x /start.sh
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Atur port yang akan diekspos oleh Nginx
EXPOSE 8080

# Jalankan skrip start saat container dinyalakan
CMD ["/start.sh"]