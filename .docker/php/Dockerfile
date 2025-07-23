# Image de base
FROM php:8.2-fpm-alpine AS base

# Installation des dépendances avec cache optimisé
RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install -j$(nproc) \
        pdo_pgsql

# Configuration
WORKDIR /var/www/html

# Optimisation des permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
