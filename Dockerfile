# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Copy the application code to the container
COPY . /var/www/html/

# Install the mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Expose port 80 to the outside world
EXPOSE 80

# Configure Apache to allow .htaccess (if needed)
# RUN a2enmod rewrite

# Restart Apache to apply changes
# RUN service apache2 restart