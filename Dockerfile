# Use official PHP 8.2 Apache image
FROM php:8.2-apache

# -------------------------------
# 1. Install system dependencies
# -------------------------------
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

# -------------------------------
# 2. Set working directory
# -------------------------------
WORKDIR /var/www

# -------------------------------
# 3. Install Composer
# -------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -------------------------------
# 4. Copy Composer files first (for cache)
# -------------------------------
COPY composer.json composer.lock ./

# Install PHP dependencies (no scripts yet)
RUN composer install --no-dev --no-scripts --optimize-autoloader

# -------------------------------
# 5. Copy Node.js package files and install deps
# -------------------------------
COPY package.json package-lock.json vite.config.js ./
RUN npm ci

# -------------------------------
# 6. Copy the rest of the application
# -------------------------------
COPY . .

# -------------------------------
# 7. Build frontend assets with Vite
# -------------------------------
RUN npm run build

# -------------------------------
# 8. Re-run Composer (now artisan exists)
# -------------------------------
RUN composer install --no-dev --optimize-autoloader

# -------------------------------
# 9. Optimize Laravel for production
# -------------------------------
RUN php artisan optimize

# -------------------------------
# 10. Point Apache to Laravel public dir
# -------------------------------
RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf

# -------------------------------
# 11. Change Apache port for Render
# -------------------------------
RUN sed -i 's/80/10000/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# -------------------------------
# 12. Fix permissions
# -------------------------------
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# -------------------------------
# 13. Expose Render’s port
# -------------------------------
EXPOSE 10000

# -------------------------------
# 14. Start Apache
# -------------------------------
CMD ["apache2-foreground"]
