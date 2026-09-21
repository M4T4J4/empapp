# Utilisation de la version officielle stable qui embarque PHP 8.2
FROM richarvey/nginx-php-fpm:3.1.6

COPY . /var/www/html

ENV WEBROOT /var/www/html/public
ENV APP_ENV production
ENV COMPOSER_ALLOW_SUPERUSER 1

# Installation en ignorant les stricts requis de plateforme lors du build Docker
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

EXPOSE 80

ENTRYPOINT ["/var/www/html/scripts/00-laravel-deploy.sh"]
