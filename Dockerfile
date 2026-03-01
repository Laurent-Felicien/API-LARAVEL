# Image officielle PHP 8.4
FROM php:8.4-cli

# Installation des extensions PHP nécessaires à Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql mbstring xml bcmath

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copier tout le projet
COPY . .

# Créer le .env depuis .env.example
RUN cp .env.example .env

# Installer les dépendances sans scripts
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-reqs

# Générer la clé
RUN php artisan key:generate --force

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=$PORT
