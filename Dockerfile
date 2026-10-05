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
    nginx && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Répertoire de travail
WORKDIR /var/www

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie des fichiers du projet
COPY . /var/www

# Installation des dépendances Composer
RUN composer install --no-dev --optimize-autoloader

# Permissions de stockage, cache et assets publics
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public

# Configuration Nginx
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

# Script de démarrage propre
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php-fpm -D && \
    nginx -g 'daemon off;'
