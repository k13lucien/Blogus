# Étape 1 : Base PHP avec extensions nécessaires
FROM php:8.2-cli

# Installer extensions PHP et outils nécessaires
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    curl nodejs npm \
  && docker-php-ext-install pdo_mysql mbstring xml zip gd bcmath

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier fichiers de projet
COPY . .

# Installer dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Exposer le port utilisé par artisan serve
EXPOSE 8000

# Commande par défaut : Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]