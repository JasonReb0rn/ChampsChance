FROM php:8.1-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Enable Apache modules
RUN a2enmod headers rewrite

# Additional security for Apache
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf \
    && echo "ServerSignature Off" >> /etc/apache2/apache2.conf

# Configure GD with JPEG support
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/

# Install the PHP MySQL extension, GD extension, and exif extension
RUN docker-php-ext-install mysqli pdo_mysql gd exif

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy your application files into the container
COPY . /var/www/html

# Serve home.php
RUN echo "DirectoryIndex home.php home.html" >> /etc/apache2/apache2.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configure PHP error reporting
RUN echo "error_reporting = E_ERROR" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Custom PHP configuration
RUN echo "upload_max_filesize = 50M" >> /usr/local/etc/php/conf.d/custom-php.ini \
    && echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/custom-php.ini

# Expose port 80 to allow external access
EXPOSE 80

# Run composer install
RUN cd /var/www/html && composer install