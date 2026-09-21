# 1. Utiliser impérativement la version PHP adaptée à Laravel 13
FROM richarvey/nginx-php-fpm:3.1.6-php8.3

COPY . /var/www/html

ENV WEBROOT /var/www/html/public
ENV APP_ENV production
ENV COMPOSER_ALLOW_SUPERUSER 1

# 2. On garde la commande classique (plus besoin d'ignorer la plateforme)
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80

ENTRYPOINT ["/var/www/html/scripts/00-laravel-deploy.sh"]