FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /opt/webapp

# Install additional packages
RUN apk --no-cache add \
    nginx \
    supervisor \
    npm \
    && docker-php-ext-enable opcache

# Install PHP extensions
RUN set -ex \
    && apk --no-cache add \
      postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Nginx configuration
COPY conf.d/nginx/default.conf /etc/nginx/nginx.conf

# Copy PHP configuration
COPY conf.d/php-fpm/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

COPY conf.d/php/php.ini /usr/local/etc/php/conf.d/php.ini

COPY conf.d/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Copy Supervisor configuration
COPY conf.d/supervisor/supervisord.conf /etc/supervisord.conf
COPY conf.d/supervisor/supervisord-dev.conf /etc/supervisord-dev.conf

# Copy Laravel application files
COPY . /opt/webapp

# Set up permissions
RUN chown -R www-data:www-data /opt/webapp \
    && chmod -R 755 /opt/webapp/storage \
    && chmod -R ugo+rw /opt/webapp/storage

# Scheduler setup

# Create a log file
RUN touch /var/log/cron.log

# Add cron job directly to crontab
RUN echo "* * * * * /usr/local/bin/php /opt/webapp/artisan schedule:run >> /var/log/cron.log 2>&1" | crontab -

# Expose ports
EXPOSE 80

ADD entrypoint.sh /root/entrypoint.sh

RUN ["chmod", "+x", "/root/entrypoint.sh"]

ENTRYPOINT ["sh", "/root/entrypoint.sh"]
