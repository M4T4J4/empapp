# =========================================================
# Stage 1 : Build des assets frontend
# =========================================================
FROM node:22 AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build


# =========================================================
# Stage 2 : Laravel + PHP + Apache
# =========================================================
FROM php:8.4-apache

WORKDIR /var/www/html

# ---------------------------------------------------------
# Installation des dépendances système
# ---------------------------------------------------------
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


# ---------------------------------------------------------
# Configuration Apache pour Laravel
# ---------------------------------------------------------
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf


# ---------------------------------------------------------
# Installation de Composer
# ---------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ---------------------------------------------------------
# Copie du projet Laravel
# ---------------------------------------------------------
COPY . .


# ---------------------------------------------------------
# Copier les assets compilés par Vite/Tailwind
# ---------------------------------------------------------
COPY --from=frontend /app/public/build ./public/build


# ---------------------------------------------------------
# Installer les dépendances Laravel
# ---------------------------------------------------------
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


# ---------------------------------------------------------
# Création de la base SQLite
# ---------------------------------------------------------
RUN touch database/database.sqlite


# ---------------------------------------------------------
# Permissions Laravel
# ---------------------------------------------------------
RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 775 storage bootstrap/cache database


# ---------------------------------------------------------
# Nettoyage des caches
# ---------------------------------------------------------
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear


# ---------------------------------------------------------
# Port Apache
# ---------------------------------------------------------
EXPOSE 80


# ---------------------------------------------------------
# Démarrage Apache
# ---------------------------------------------------------
CMD ["apache2-foreground"]