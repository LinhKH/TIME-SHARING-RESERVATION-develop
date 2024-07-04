FROM php:7.4-apache

RUN apt-get -y update && apt-get -y install vim curl git zip unzip libpng-dev zlib1g-dev libzip-dev libmagickwand-dev
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash
RUN apt-get -y install nodejs
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip

RUN docker-php-ext-enable pdo_mysql
RUN docker-php-ext-enable gd
RUN docker-php-ext-enable zip

RUN pecl install imagick
RUN docker-php-ext-enable imagick

RUN echo "=====INSTALL COMPOSER====="
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN echo "=====INSTALL COMPOSER COMPLETED====="

RUN a2enmod rewrite ssl

WORKDIR /var/www/html

EXPOSE 80 443
COPY ./scripts.sh /scripts.sh

COPY ./ssl /usr/local/apache2/conf/

ENTRYPOINT ["/scripts.sh"]
