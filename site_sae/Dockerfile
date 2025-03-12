FROM php:8.3-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y nginx \
    && apt-get install -y libzip-dev \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y git \
    && apt-get install -y libonig-dev \
    && apt-get install -y libpng-dev \
    && apt-get install -y libjpeg-dev \
    && apt-get install -y libfreetype6-dev \
    && apt-get install -y libwebp-dev \
    && apt-get install -y libxpm-dev \
    && apt-get install -y libxml2-dev \
    && apt-get install -y libicu-dev \
    && apt-get install -y libxslt-dev \
    && apt-get install -y libpq-dev \
    && apt-get install -y libbz2-dev \
    && apt-get install -y libldap2-dev \
    && apt-get install -y libmcrypt-dev \
    && apt-get install -y libreadline-dev \
    && apt-get install -y libtidy-dev \
    && apt-get install -y libgmp-dev \
    && apt-get install -y libpspell-dev \
    && apt-get install -y libsnmp-dev \
    && apt-get install -y libpcre3-dev \
    && docker-php-ext-install pdo pdo_mysql

COPY . /var/www

# Copiez une configuration Nginx
COPY ./nginx.conf /etc/nginx/nginx.conf

# Assurer que les permissions sont correctes pour Laravel
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Installez le client MySQL
RUN apt-get update && apt-get install -y default-mysql-client

# Installez Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installez les dépendances PHP
RUN composer install --ignore-platform-req=ext-exif --no-dev --optimize-autoloader

# Configuration de l’environnement
RUN cp .env.example .env
RUN sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
RUN sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
RUN sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
RUN sed -i "s/APP_ENV=.*/APP_ENV=production/" .env
RUN sed -i "s/APP_DEBUG=.*/APP_DEBUG=false/" .env
RUN sed -i "s/APP_URL=.*/APP_URL=http:\/\/$DOMAIN/" .env

# Générer une clé d'application
RUN php artisan key:generate

# Exécutez les migrations et les seeders
RUN php artisan migrate --seed

RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Mise en mode production
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan optimize
RUN npm install --production
RUN npm install -D vite
RUN npm run build

# Expose le port 80
EXPOSE 80

# Exécutez Nginx et PHP-FPM
CMD ["sh", "-c", "nginx && php-fpm"]
