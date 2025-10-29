# Use official PHP 8.2 Apache image
FROM php:8.2-apache

# Install system dependencies and PHP extensions required for Laravel + PostgreSQL + Node.js
RUN apt-get update && apt-get install -y \
    curl \
    gnupg \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip \
    # Install Node.js 20.x (for Vite build)
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Set working directory to /var/www (Laravel app root)
WORKDIR /var/www

# Install Composer (use latest version)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install PHP dependencies without running scripts yet
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Copy package files for Node.js build
COPY package.json package-lock.json vite.config.js ./

# Install Node.js dependencies (package files only)
RUN npm ci

# Copy the rest of the application (artisan, bootstrap, resources, etc.)
COPY . .

# Build frontend assets AFTER all resources are present
RUN npm run build

# Now run Composer scripts (artisan exists now)
RUN composer install --no-dev --optimize-autoloader

# Point Apache DocumentRoot to Laravel's public directory
RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf

# Change Apache to listen on Render's required port (10000)
RUN sed -i 's/80/10000/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Set correct permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 10000 for Render
EXPOSE 10000

# Start Apache service
CMD ["apache2-foreground"]
