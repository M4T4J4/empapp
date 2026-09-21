# =========================================================
# ÉTAPE 1 : BUILD FRONTEND
# =========================================================
FROM node:22 AS frontend

WORKDIR /app

# Copier les fichiers npm
COPY package*.json ./

# Installer les dépendances
RUN npm install

# Copier tout le projet
COPY . .

# Compiler Tailwind + Vite
RUN npm run build


# =========================================================
# ÉTAPE 2 : LARAVEL + PHP 8.4 + APACHE
# =========================================================
FROM php:8.4-apache

WORKDIR /var/www/html


# =========================================================
# DÉPENDANCES SYSTÈME
# =========================================================
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*


# =========================================================
# CONFIGURATION APACHE POUR LARAVEL
# =========================================================
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf


# =========================================================
# INSTALLATION DE COMPOSER
# =========================================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# =========================================================
# COPIE DU PROJET LARAVEL
# =========================================================
COPY . .


# =========================================================
# COPIE DES ASSETS VITE / TAILWIND
# =========================================================
COPY --from=frontend /app/public/build ./public/build


# =========================================================
# INSTALLATION DES DÉPENDANCES PHP
# =========================================================
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


# =========================================================
# CRÉATION DE LA BASE SQLITE
# =========================================================
RUN mkdir -p database \
    && touch database/database.sqlite


# =========================================================
# PERMISSIONS LARAVEL
# =========================================================
RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 775 storage bootstrap/cache database


# =========================================================
# NETTOYAGE DES CACHES
# =========================================================
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear


# =========================================================
# PORT
# =========================================================
EXPOSE 80


# =========================================================
# DÉMARRAGE
# =========================================================
CMD ["sh", "-c", "php artisan migrate --force && apache2-foreground"]