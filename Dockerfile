# Utilisation de l'image de production Bitnami avec PHP 8.3 de manière native
FROM bitnami/laravel:11-debian-12

COPY . /app

WORKDIR /app

ENV APP_ENV production
ENV COMPOSER_ALLOW_SUPERUSER 1

# Installation propre sans vérification stricte mais sur l'environnement PHP 8.3 réel
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

# Lance le serveur intégré optimisé de Bitnami et exécute notre script en amont
ENTRYPOINT ["/app/scripts/00-laravel-deploy.sh"]
CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=8000" ]
