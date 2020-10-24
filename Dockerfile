FROM php:7.4-fpm

RUN apt update && apt install -y vim git curl wget zip unzip libpq-dev libzip-dev

RUN apt clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
