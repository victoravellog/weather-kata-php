FROM php:8.1-fpm

RUN apt-get update -y
RUN apt-get upgrade -y
RUN apt-get install git -y
RUN apt-get install make -y
RUN apt-get install zip unzip -y

WORKDIR /app

COPY . .

#RUN apt get --no-cache $PHPIZE_DEPS \
 #   && pecl install xdebug \
  #  && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# CMD ["/bin/sh"]

#CMD ["make", "install", "tests", "-f", "Makefile"]