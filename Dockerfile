# Use the official PHP 8 image with Apache
FROM php:8-apache

# Set user variables
ARG UID=1000
ARG GID=1000

# Modify user and group for www-data
RUN groupmod -g ${GID} www-data && usermod -u ${UID} -g www-data www-data

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y git curl unzip libzip-dev libicu-dev && \
    docker-php-ext-install pdo pdo_mysql zip intl opcache && \
    pecl install apcu && docker-php-ext-enable apcu && \
    a2enmod rewrite && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Add custom php.ini settings
RUN echo "upload_max_filesize = 32M" >> /usr/local/etc/php/php.ini && \
    echo "post_max_size = 32M" >> /usr/local/etc/php/php.ini && \
    echo "memory_limit = 256M" >> /usr/local/etc/php/php.ini && \
    echo "opcache.enable=1" >> /usr/local/etc/php/php.ini && \
    echo "opcache.memory_consumption=256" >> /usr/local/etc/php/php.ini && \
    echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/php.ini && \
    echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/php.ini && \
    echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/php.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application source and set permissions
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html

# Apache configurations
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    DirectoryIndex index.php\n\
    </Directory>\n' > /etc/apache2/conf-available/symfony.conf && \
    a2enconf symfony && \
    sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf
