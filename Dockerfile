FROM richarvey/nginx-php-fpm:3.1.6

COPY . /var/www/html

ENV WEBROOT /var/www/html/public
ENV APP_ENV production
ENV APP_DEBUG false

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Donne les bonnes permissions aux dossiers de cache/stockage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["/start.sh"]
