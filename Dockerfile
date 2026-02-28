# On part d'une image officielle PHP 8.4 avec Apache
FROM php:8.4-cli

# Installation des extensions PHP nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring xml bcmath

# Installation de Composer (gestionnaire de dépendances PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail dans le conteneur
WORKDIR /app

# Copier les fichiers de dépendances en premier (optimisation cache Docker)
COPY composer.json composer.lock ./

# Installer les dépendances PHP sans les packages de dev
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Copier tout le reste du projet
COPY . .

# Générer la clé Laravel si elle n'existe pas
RUN php artisan key:generate --force

# Exposer le port 8000
EXPOSE 8000

# Commande de démarrage
CMD php artisan serve --host=0.0.0.0 --port=$PORT
