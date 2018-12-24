FROM ubuntu:bionic
LABEL org.label-schema.name="Jano Ticketing System" \
    maintainer="Andrew Ying <hi@andrewying.com>" \
    org.label-schema.description="Official Docker image for the Jano Ticketing System" \
    org.label-schema.vcs-url="https://github.com/jano-may-ball/ticketing" \
    org.label-schema.schema-version="1.0"

ARG BUILD_ENV=development
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get install -y --no-install-recommends apt-utils curl gnupg wget software-properties-common
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - \
    && add-apt-repository ppa:ondrej/php
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        vim \
        htop \
        mariadb-server \
        redis-server \
        supervisor \
        openssl \
        openssh-server \
        apache2 \
        apache2-bin \
        apache2-data \
        apache2-utils \
        libapache2-mod-php7.1 \
        php7.1 \
        php7.1-xdebug \
        php7.1-mysql \
        php7.1-redis \
        php7.1-mbstring \
        php7.1-tokenizer \
        php7.1-bcmath \
        php7.1-gd \
        php7.1-xml \
        php7.1-curl \
        php7.1-zip \
        php7.1-bz2 \
        unzip \
        nodejs \
        sudo

RUN a2enmod rewrite
RUN sed -ie 's/upload_max_filesize\ =\ 2M/upload_max_filesize\ =\ 200M/g' /etc/php/7.1/apache2/php.ini \
    && sed -ie 's/post_max_size\ =\ 8M/post_max_size\ =\ 200M/g' /etc/php/7.1/apache2/php.ini \
    && sed -ie 's/bind/# bind/g' /etc/redis/redis.conf \
    && sed -ie 's/daemonize yes/daemonize no/g' /etc/redis/redis.conf
RUN set -xe; \
    bash -c "mysqld_safe --user=mysql &"; \
    sleep 10; \
    echo "GRANT ALL ON *.* TO root@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION; FLUSH PRIVILEGES" | mysql; \
    echo "CREATE DATABASE jano" | mysql -u root -ppassword
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get clean \
    && rm -rf /var/cache/apt/archives/* /var/lib/apt/lists/* /root/.composer /var/www/jano/node_modules
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY .codeship /var/www/codeship
RUN chmod +x /var/www/codeship/*

COPY . /var/www/jano
WORKDIR /var/www/jano

RUN chown -R www-data:www-data /var/www/jano \
    && if [ "$BUILD_ENV" = "development" ]; \
           then HOME=/var/www/jano sudo -u www-data composer install --prefer-source --no-interaction \
                && curl https://raw.githubusercontent.com/fossas/fossa-cli/master/install.sh | bash \
                && fossa init; \
           else HOME=/var/www/jano sudo -u www-data composer install --prefer-source --no-dev --no-interaction; \
       fi \
    && sudo -u www-data openssl genpkey -algorithm RSA -out storage/oauth-private.key -pkeyopt rsa_keygen_bits:2048 \
    && sudo -u www-data openssl rsa -in storage/oauth-private.key -outform PEM -pubout -out storage/oauth-public.key \
    && HOME=/var/www/jano sudo -u www-data npm install \
    && if [ "$BUILD_ENV" = "development" ]; \
           then HOME=/var/www/jano sudo -u www-data npm run development; \
           else HOME=/var/www/jano sudo -u www-data npm run production; \
       fi

RUN rm -rf /var/www/html \
    && ln -s /var/www/jano/public /var/www/html
RUN set -xe; \
    bash -c "mysqld --user=mysql &"; \
    sleep 20; \
    sudo -u www-data php jano migrate --seed --force

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]