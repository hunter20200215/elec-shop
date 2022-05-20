# Base image
FROM php:8-apache

ENV TZ=Europe/Belgrade
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql && apt-get install -y lsof git zip unzip sudo nano supervisor
RUN apt-get install -y libpng-dev
RUN apt-get update && apt-get install -y \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev libxpm-dev \
    libfreetype6-dev

RUN docker-php-ext-install pcntl
RUN docker-php-ext-configure gd \
    --with-webp \
    --with-jpeg \
    --with-xpm \
    --with-freetype

RUN docker-php-ext-install gd

RUN apt-get install -y certbot python-certbot-apache

COPY horizon_supervisor.conf /etc/supervisor/conf.d/horizon.conf

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT /var/www/httpd/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

WORKDIR /var/www/httpd

CMD ["apache2-foreground"]
