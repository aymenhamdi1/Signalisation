#!/bin/bash


# Chemin vers votre projet Laravel

PROJECT_DIR="/var/www/DBR"


# Se déplacer dans le répertoire du projet

cd "$PROJECT_DIR" || { echo "Échec de l'accès au répertoire $PROJECT_DIR"; exit 1; }


# Effacer les caches

echo "Nettoyage des caches..."

php artisan cache:clear

php artisan route:clear

php artisan config:clear

php artisan view:clear


# Démarrer le serveur Laravel

echo "Démarrage du serveur Laravel..."

php artisan serve --host=0.0.0.0 --port=8000


# Message de fin

echo "Le serveur Laravel a été arrêté."
