FROM php:8.2-fpm

# Installation des extensions PHP et outils requis
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

# Répertoire de travail
WORKDIR /var/www

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie des fichiers du projet
COPY . /var/www

# Installation des dépendances Composer
RUN composer install --no-dev --optimize-autoloader

# Permissions de stockage et de cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Configuration Nginx
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

# Lancement des migrations, seeders, caches et des services
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php-fpm -D && \
    nginx -g 'daemon off;'