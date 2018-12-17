FROM ubuntu:bionic
MAINTAINER Andrew Ying <hi@andrewying.com>

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y apt-utils curl gnupg wget
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y software-properties-common && add-apt-repository ppa:ondrej/php
RUN apt-get update && apt-get install -y \
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
    && sed -ie 's/post_max_size\ =\ 8M/post_max_size\ =\ 200M/g' /etc/php/7.1/apache2/php.ini
RUN set -xe; \
    bash -c "mysqld_safe --user=mysql &"; \
    sleep 10; \
    echo "GRANT ALL ON *.* TO root@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION; FLUSH PRIVILEGES" | mysql; \
    echo "CREATE DATABASE jano" | mysql -u root -ppassword
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/jano

RUN chown www-data:www-data /var/www/jano \
    && cd /var/www/jano \
    && sudo -u www-data composer install --prefer-source --no-interaction \
    && sudo -u www-data openssl genpkey -algorithm RSA -out storage/oauth-private.key -pkeyopt rsa_keygen_bits:2048 \
    && sudo -u www-data openssl rsa -in storage/oauth-private.key -outform PEM -pubout -out storage/oauth-public.key \
    && HOME=/var/www/jano sudo -u www-data npm install \
    && HOME=/var/www/jano sudo -u www-data npm run production
RUN rm -rf /var/www/html \
    && ln -s /var/www/jano/public /var/www/html
RUN set -xe; \
    cd /var/www/jano; \
    bash -c "mysqld --user=mysql &"; \
    sleep 20; \
    sudo -u www-data php jano migrate --seed --force

RUN apt-get clean \
    && rm -rf /var/cache/apt/archives/* /var/lib/apt/lists/* /root/.composer /var/www/jano/node_modules
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["supervisord"]