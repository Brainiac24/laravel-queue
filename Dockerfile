FROM php:7.2-fpm
#WORKDIR /usr/share/nginx/www/code
#VOLUME /d/docker/src/code:/usr/share/nginx/www/code
#COPY start.sh /usr/local/bin/start
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    unzip \
    libxml2-dev \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install pdo_mysql zip pcntl soap \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN chmod u+x /usr/local/bin/start
  #  && composer install \
  #  && chmod -R 777 /code/storage/
#CMD ["/usr/local/bin/start"]