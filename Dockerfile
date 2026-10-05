FROM php:8.2-fpm

# Installation des dépendances système et des extensions PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Installation des dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissions pour le stockage et le cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Remplacement de la configuration Nginx
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

# Démarrage des caches et des services
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php-fpm -D && \
    nginx -g 'daemon off;'
