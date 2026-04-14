FROM php:8.2-apache

# PostgreSQL 드라이버 설치
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Apache rewrite (선택)
RUN a2enmod rewrite

COPY . /var/www/html
