FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/html

# Ensure directories have correct ownership
RUN chown -R www-data:www-data /var/www/html

# Set working directory
WORKDIR /var/www/html

# Switch to the www-data user before running Composer and npm
USER www-data

# Copy .env file
COPY .env.example .env

# Install PHP dependencies
RUN COMPOSER_CACHE_DIR=/var/www/html/.cache/composer composer install

# Install Node.js dependencies
RUN npm install --cache /var/www/html/.cache/npm

# Build the frontend with Vite
RUN npm run build

USER root

# Set app key
RUN php artisan key:generate

# Create storage link
RUN php artisan storage:link

# Start php-fpm server
CMD ["php-fpm"]