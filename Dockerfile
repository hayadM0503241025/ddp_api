# 1. Gunakan PHP 8.2 dengan FPM (Standar Laravel)
FROM php:8.2-fpm

# 2. Install library sistem yang dibutuhkan Linux
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev

# 3. Install ekstensi PHP agar bisa baca database MySQL dan Gambar
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Ambil Composer (Alat instal library Laravel)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Tentukan folder kerja di dalam mesin Docker
WORKDIR /var/www

# 6. Copy kodingan Laravel Mas dari laptop ke dalam mesin Docker
COPY . /var/www

# 7. Install library Laravel secara otomatis (tanpa skrip yang bikin error)
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# 8. Berikan izin akses folder agar gambar bisa diupload
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# 9. Jalankan server di port 8000
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000