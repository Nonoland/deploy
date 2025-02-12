FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Install app dependencies
COPY composer.json composer.lock ./
RUN composer install

# Copy app source code
COPY . .

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
