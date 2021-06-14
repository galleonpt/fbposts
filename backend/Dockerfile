FROM php:7.3-apache


RUN apt-get update && apt-get install -y zip unzip git libmcrypt-dev && apt-get install libssh2-1-dev -y \
    && pecl install mcrypt-1.0.2 \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install pdo_mysql

RUN apt-get update && \
  apt-get install -y autoconf pkg-config libssl-dev git libzip-dev zlib1g-dev && \
  pecl install mongodb && docker-php-ext-enable mongodb && \
  pecl install xdebug && docker-php-ext-enable xdebug && \
  docker-php-ext-install -j$(nproc) pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN a2enmod rewrite

RUN apt-get install vim -y
RUN apt-get install wget -y

# COPY ./apm/ /apm
RUN curl -L -O https://github.com/elastic/apm-agent-php/releases/download/v1.0.0-beta1/apm-agent-php_1.0.0-beta1_all.deb
RUN dpkg -i apm-agent-php_1.0.0-beta1_all.deb
RUN rm -rf apm-agent-php-beta1_all.deb
RUN echo "elastic_apm.log_level=NOTICE">>/usr/local/etc/php/php.ini
RUN echo "elastic_apm.log_level_syslog=TRACE" >> /usr/local/etc/php/php.ini
# RUN pip3 install flask requests
# ENV ELASTIC_APM_SERVER_URL http://localhost:80

RUN wget https://phar.phpunit.de/phpunit-6.5.phar \
    && chmod +x phpunit-6.5.phar \
    && mv phpunit-6.5.phar /usr/local/bin/phpunit

COPY . /var/www/html/
COPY ./config/apache2.conf /etc/apache2/apache2.conf
COPY ./config/httpd.conf /etc/apache2/httpd.conf
COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
EXPOSE 80
