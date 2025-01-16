FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libonig-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY app/ /var/www/html/

RUN composer install

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "www"]
