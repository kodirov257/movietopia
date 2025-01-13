FROM php:8.3-fpm

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

RUN apt-get update && apt-get install -y libpq-dev libzip-dev zlib1g-dev libgd-dev libjpeg-dev libpng-dev libwebp-dev libfreetype6-dev git libmagickwand-dev pkg-config \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install pdo_pgsql zip pcntl gd exif \
    && git clone https://github.com/Imagick/imagick.git /usr/src/php/ext/imagick \
    && docker-php-ext-configure /usr/src/php/ext/imagick \
    && docker-php-ext-install /usr/src/php/ext/imagick \
    && docker-php-ext-enable imagick \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html
