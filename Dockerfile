# Image Docker officielle optimisée avec Nginx et PHP 8.3 natif
FROM webdevops/php-nginx:8.3

COPY . /app
WORKDIR /app

ENV WEBROOT /app/public
ENV APP_ENV production
ENV COMPOSER_ALLOW_SUPERUSER 1

# Installation propre des dépendances de Laravel 13
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80

ENTRYPOINT ["/app/scripts/00-laravel-deploy.sh"]
