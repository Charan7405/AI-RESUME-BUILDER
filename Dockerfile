FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libpng-dev libxml2-dev libonig-dev zip curl \
    && docker-php-ext-install pdo pdo_pgsql zip gd mbstring xml bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

EXPOSE 10000

CMD php artisan config:clear && php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT