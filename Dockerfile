FROM php:8.4-cli

# Instalasi dependensi sistem, ekstensi PostgreSQL, dan curl/gnupg untuk Node.js
RUN apt-get update -y && apt-get install -y libpq-dev unzip git curl gnupg
RUN docker-php-ext-install pdo pdo_pgsql

# Install Node.js (Versi 20.x) dan npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /app
COPY . /app

# Jalankan composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Perintah untuk menjalankan Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]