FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    zip \
    git \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Configure Nginx
COPY .docker/nginx/default.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
RUN rm -f /etc/nginx/sites-enabled/default.bak

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Create start script
RUN echo '#!/bin/bash\nphp-fpm -D\nnginx -g "daemon off;"' > /start.sh
RUN chmod +x /start.sh

# Expose port 80
EXPOSE 80

# Start both services
CMD ["/start.sh"]
