FROM php:8.2-apache

# System packages + PHP extensions WordPress needs.
RUN apt-get update && apt-get install -y \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libicu-dev \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        mysqli \
        pdo_mysql \
        gd \
        zip \
        intl \
        exif \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Allow .htaccess overrides so WordPress pretty permalinks work.
RUN { \
        echo '<Directory /var/www/html>'; \
        echo '    AllowOverride All'; \
        echo '</Directory>'; \
    } > /etc/apache2/conf-available/wordpress-overrides.conf \
    && a2enconf wordpress-overrides

# Reasonable upload/memory limits for media uploads (default PHP image is 2M).
RUN { \
        echo 'upload_max_filesize = 64M'; \
        echo 'post_max_size = 64M'; \
        echo 'memory_limit = 256M'; \
    } > /usr/local/etc/php/conf.d/wordpress-uploads.ini

WORKDIR /var/www/html
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
