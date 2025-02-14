FROM php:8.3-fpm

COPY composer.lock composer.json /var/www/html

WORKDIR /var/www/html

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

# # Create group with GID 1000 if it doesn't already exist (named 'group_1000' here for clarity)
# RUN groupadd -g 1000 group_1000 || true

# # Add the user 'www-data' to the group 'group_1000'
# RUN usermod -aG group_1000 www-data

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# Copy .env file
COPY .env.example .env

# Ensure directories exist and have the correct permissions
RUN mkdir -p /var/www/html/public/build && chown -R www-data:www-data /var/www/html/public

# Install PHP dependencies
RUN COMPOSER_CACHE_DIR=/var/www/html/.cache/composer composer install

# Install Node.js dependencies
RUN npm install --cache /var/www/html/.cache/npm

# Ensure node_modules has correct permissions
RUN chown -R www-data:www-data /var/www/html/node_modules

# Copy Vite config with
COPY --chown=www-data:www-data ./vite.config.js /var/www/html/vite.config.js

# Set app key
RUN php artisan key:generate

# Create storage link
RUN php artisan storage:link

RUN chown -R www-data:www-data /var/www/html/public/build

# Switch to user
USER www-data

# Build the frontend with Vite
RUN npm run build

# Start php-fpm server
CMD ["php-fpm"]