FROM php:8.3.8-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor \
    nginx \
    build-essential \
    openssl

RUN docker-php-ext-install gd pdo pdo_mysql sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG URL_INSTALL_CLIENT_BASIC='https://download.oracle.com/otn_software/linux/instantclient/217000/instantclient-basic-linux.x64-21.7.0.0.0dbru.zip'
ARG URL_INSTALL_CLIENT_SDK='https://download.oracle.com/otn_software/linux/instantclient/217000/instantclient-sdk-linux.x64-21.7.0.0.0dbru.zip'

RUN apt install -y unzip curl libaio1

RUN mkdir /opt/oracle
RUN curl ${URL_INSTALL_CLIENT_BASIC} --output /opt/oracle/instantclient-basic-linux.zip
RUN curl ${URL_INSTALL_CLIENT_SDK} --output /opt/oracle/instantclient-sdk-linux.zip
RUN unzip '/opt/oracle/instantclient-basic-linux.zip' -d /opt/oracle
RUN unzip '/opt/oracle/instantclient-sdk-linux.zip' -d /opt/oracle
RUN rm /opt/oracle/instantclient-*.zip
RUN mv /opt/oracle/instantclient_* /opt/oracle/instantclient
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient
RUN docker-php-ext-install oci8
RUN echo /opt/oracle/instantclient/ > /etc/ld.so.conf.d/oracle-insantclient.conf
RUN ldconfig

# Install MongoDB extension
RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb


# Set PHP configurations
# COPY php.ini /usr/local/etc/php/php.ini

# # Enable PHP error logging, environment variable forwarding for FPM workers and set up TERM variable
# RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf
# RUN echo "clear_env = no" >> /usr/local/etc/php-fpm.d/www.conf
# RUN echo "export TERM=xterm" >> /etc/bash.bashrc

# Set the working directory
WORKDIR /var/www/html

# # Copy the init.sh script
# COPY init.sh /usr/local/bin/init.sh

# # Convert line endings to Unix format and make the script executable
# RUN tr -d '\r' < /usr/local/bin/init.sh > /usr/local/bin/init_unix.sh \
#   && mv /usr/local/bin/init_unix.sh /usr/local/bin/init.sh \
#   && chmod +x /usr/local/bin/init.sh

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Command to start PHP-FPM
CMD ["php-fpm"]
