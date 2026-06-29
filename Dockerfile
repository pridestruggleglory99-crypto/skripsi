OPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --optimize-autoloader

# Build frontend
RUN npm install
RUN npm run build

# Laravel permissions
RUN chmod -R 775 storage bootstrap/cache

CMD sh -c "php artisan optimize:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}}"