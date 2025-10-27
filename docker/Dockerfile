# Use an official PHP-FPM 8.2 image as the base
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Set non-interactive frontend
ARG DEBIAN_FRONTEND=noninteractive

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    unzip \
    zip \
    vim \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libxslt1-dev \
    libicu-dev \
    libpq-dev \
    libedit-dev \
    libreadline-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    libsodium-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        mysqli \
        pdo_mysql \
        mbstring \
        bcmath \
        intl \
        zip \
        exif \
        opcache \
        xsl \
        calendar \
        sockets \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Timezone & PHP configuration tweaks
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && sed -i "s/post_max_size = .*/post_max_size = 64M/" /usr/local/etc/php/php.ini \
    && sed -i "s/upload_max_filesize = .*/upload_max_filesize = 64M/" /usr/local/etc/php/php.ini \
    && sed -i "s/memory_limit = .*/memory_limit = 1024M/" /usr/local/etc/php/php.ini \
    && sed -i "s/max_execution_time = .*/max_execution_time = 600/" /usr/local/etc/php/php.ini \
    && sed -i "s/;date.timezone =.*/date.timezone = \"Asia\/Dhaka\"/" /usr/local/etc/php/php.ini

# Configure Nginx
# Configure Nginx
COPY  docker/nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Start script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Expose web port
EXPOSE 80

# Default CMD
CMD ["/start.sh"]
