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

# Installation des extensions PHP (avec pdo_pgsql pour PostgreSQL/Supabase)
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Répertoire de travail
WORKDIR /var/www

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie d'abord des fichiers de dépendances pour optimiser le cache Docker
COPY composer.json composer.lock ./

# Installation des dépendances Composer
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Copie du reste des fichiers du projet
COPY . /var/www

# Fin des scripts Composer post-install
RUN composer dump-autoload --no-dev --optimize-autoloader

# Permissions de stockage, cache et assets publics
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public

# Configuration Nginx
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

# Script de démarrage propre (nettoyage des caches pour forcer la lecture de DATABASE_URL)
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear && \
    php-fpm -D && \
    nginx -g 'daemon off;'
