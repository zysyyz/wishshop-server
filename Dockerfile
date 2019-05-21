FROM php:7.2.0-apache

RUN apt-get update     \
 && apt-get install -y \
      libmcrypt-dev \
      libz-dev      \
      git           \
      cron          \
      vim

RUN docker-php-ext-install \
      mbstring  \
      pdo_mysql \
      zip       \
 && apt-get clean      \
 && apt-get autoclean  \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD docker/_linux/var/spool/cron/crontabs/root /var/spool/cron/crontabs/root
RUN chown -R root:crontab /var/spool/cron/crontabs/root \
 && chmod 600 /var/spool/cron/crontabs/root
RUN touch /var/log/cron.log

RUN a2enmod rewrite && \
    a2enmod deflate

ADD docker/_linux/etc/apache2/mods-available/deflate.conf /etc/apache2/mods-available/deflate.conf
RUN chown -R root:root /etc/apache2/mods-available/deflate.conf \
 && chmod 600 /etc/apache2/mods-available/deflate.conf

WORKDIR /app
COPY . /app

RUN rm -fr /var/www/html \
 && ln -s /app/public /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN chown -R www-data:www-data /app \
 && chmod -R 0777 /app/storage      \
 && composer install

ENTRYPOINT ["./docker/start.sh"]