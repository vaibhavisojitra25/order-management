# Use the official PHP 8.1 image with Apache
FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /Users/vaibhavi/solidcomp/order-management

# Copy the current directory contents to the container (for local machine, we'll override with a volume)
COPY . /Users/vaibhavi/solidcomp/order-management

# Set permissions for Laravel
RUN chown -R www-data:www-data /Users/vaibhavi/solidcomp/order-management \
    && chmod -R 775 /Users/vaibhavi/solidcomp/order-management/storage \
    && chmod -R 775 /Users/vaibhavi/solidcomp/order-management/bootstrap/cache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Expose port 80 for the web server
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
