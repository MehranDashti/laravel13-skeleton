FROM php:8.3

ARG NODE_VERSION=18
ARG POSTGRES_VERSION=15

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
# Install system dependencies
RUN apt-get update && apt-get install -y \
    gnupg \
    gosu \
    ca-certificates \
    dnsutils \
    git \
    supervisor \
    curl \
    libcap2-bin \
    libssl-dev \
    libpng-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libxml2-dev \
    libldap2-dev \
    libzip-dev \
    librsvg2-bin \
    libbrotli-dev\
    libpq-dev \
    unzip \
    openssh-server \
    zip \
    jq

# Clear cache
RUN apt-get -y autoremove && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install PHP extensions
RUN pecl install mongodb \
    &&  echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini && \
    pecl install swoole \
    pecl install redis

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd soap zip sockets pgsql pdo_pgsql

RUN docker-php-ext-enable swoole redis

# Get latest Composer
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Install app dependency
RUN mkdir /app

COPY . /app
WORKDIR /app

COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisor.conf

# Copy php config file
RUN cp docker/php/php.ini-development /usr/local/etc/php/php.ini-development
RUN cp docker/php/php.ini-production /usr/local/etc/php/php.ini-production

## Authorize SSH Host
#RUN mkdir -p /root/.ssh && \
#    chmod 0700 /root/.ssh && \
#    ssh-keyscan git.liateam.net > /root/.ssh/known_hosts
#
## Add the keys and set permissions
#RUN cp docker/.ssh/id_rsa ~/.ssh/id_rsa && \
#    chmod 600 ~/.ssh/id_rsa

# Add the keys and set permissions
RUN touch .phpunit.result.cache && \
    chmod 777 .phpunit.result.cache

RUN composer install --ignore-platform-req=ext-mongodb && \
    composer dump-autoload

RUN chown -R www-data:www-data \
        /app/storage \
        /app/bootstrap/cache

RUN php artisan optimize && \
    php artisan key:generate && \
    php artisan config:cache && \
    php artisan route:cache

RUN rm -rf ~/.ssh/id_rsa
RUN apt purge  -y \
    git \
    openssh-server

VOLUME /app

EXPOSE 8080

CMD ["/usr/bin/supervisord"]

