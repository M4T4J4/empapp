# Utilisation d'une image moderne préconfigurée avec PHP 8.3 et Nginx pour Laravel
FROM tangramor/nginx-php8-fpm:php8.3.6_node22.1.0

COPY . /var/www/html

ENV WEBROOT /var/www/html/public
ENV APP_ENV production
ENV COMPOSER_ALLOW_SUPERUSER 1

# Installation propre des dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80

ENTRYPOINT ["/var/www/html/scripts/00-laravel-deploy.sh"]
