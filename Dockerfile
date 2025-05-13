# Build stage: install Composer dependencies
FROM composer:2 AS builder
WORKDIR /app
COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader
COPY . .

# Runtime stage: use Apache + PHP 8.1
FROM php:8.1-apache
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && a2enmod rewrite
COPY --from=builder /app /var/www/html
WORKDIR /var/www/html/public
EXPOSE 80
