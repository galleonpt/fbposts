FROM php:7.3-apache

RUN apt-get update && apt-get install -y zip unzip git libmcrypt-dev && apt-get install libssh2-1-dev -y \
&& pecl install mcrypt-1.0.2 \
&& docker-php-ext-enable mcrypt \
&& docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install vim -y
RUN apt-get install apache2 -y

RUN apt-get install vim -y
RUN apt-get install cron -y
RUN apt-get install supervisor -y

COPY ./config/crontab /etc/cron.d/
RUN crontab /etc/cron.d/crontab

WORKDIR /var/www/html

CMD service cron start  \
&& service supervisor start \
&& service apache2 start \
&& tail -F /var/log/mysql/error.log

