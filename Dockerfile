# Use official PHP 8.2 Apache image
FROM php:8.2-apache

# Install system dependencies
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

# Set working directory
WORKDIR /var/www

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Composer files first (for cache)
COPY composer.json composer.lock ./

# Install PHP dependencies (no scripts yet)
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Copy Node.js package files and install deps
COPY package.json package-lock.json vite.config.js ./
RUN npm ci

# Copy the rest of the application
COPY . .

# Build frontend assets with Vite
RUN npm run build

# Re-run Composer (now artisan exists)
RUN composer install --no-dev --optimize-autoloader

# Point Apache to Laravel public dir
RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf

# Change Apache port for Render
RUN sed -i 's/80/10000/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Fix permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/public /var/www/bootstrap/cache

# Expose Render’s port
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]
