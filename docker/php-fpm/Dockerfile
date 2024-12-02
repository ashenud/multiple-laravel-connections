# Base image
FROM php:7.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    libssl-dev \
    zlib1g-dev \
    libicu-dev \
    g++ \
    libonig-dev \
    curl \
    libaio1 \
    wget

# Configure PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mysqli intl zip

# Install MongoDB extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install Oracle Instant Client and PHP OCI8 extension
# Replace <VERSION> with the Oracle Instant Client version you're using.
RUN wget https://download.oracle.com/otn_software/linux/instantclient/instantclient-basic-linux.x64-<VERSION>.zip \
    && unzip instantclient-basic-linux.x64-<VERSION>.zip -d /opt/oracle \
    && echo /opt/oracle/instantclient_19_8 > /etc/ld.so.conf.d/oracle-instantclient.conf \
    && ldconfig \
    && docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient_19_8 \
    && docker-php-ext-install oci8

# Set PHP configurations
COPY php.ini /usr/local/etc/php/php.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable PHP error logging, environment variable forwarding for FPM workers and set up TERM variable
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo "clear_env = no" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo "export TERM=xterm" >> /etc/bash.bashrc

# Set the working directory
WORKDIR /var/www/

# Copy the init.sh script
COPY init.sh /usr/local/bin/init.sh

# Convert line endings to Unix format and make the script executable
RUN tr -d '\r' < /usr/local/bin/init.sh > /usr/local/bin/init_unix.sh \
  && mv /usr/local/bin/init_unix.sh /usr/local/bin/init.sh \
  && chmod +x /usr/local/bin/init.sh

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Command to start PHP-FPM
CMD ["php-fpm"]
