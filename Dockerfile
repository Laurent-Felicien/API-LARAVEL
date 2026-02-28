# Image officielle PHP 8.4
FROM php:8.4-cli

# Installation des extensions PHP nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring xml bcmath

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# On copie TOUT le projet d'abord (artisan doit être présent pour composer)
COPY . .

# Ensuite on installe les dépendances
# --no-scripts évite que composer essaie d'exécuter artisan pendant l'install
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-reqs

# Maintenant que tout est en place, on génère la clé
RUN php artisan key:generate --force

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=$PORT
