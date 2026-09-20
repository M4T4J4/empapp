#!/usr/bin/env bash
echo "Exécution des optimisations Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optionnel : décommentez si vous utilisez une base de données
php artisan migrate --force
