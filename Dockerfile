FROM php:7.2-fpm
WORKDIR /var/www
COPY . .
RUN docker-php-ext-install pdo pdo_mysql
CMD php artisan serve --host=0.0.0.0
EXPOSE 8000