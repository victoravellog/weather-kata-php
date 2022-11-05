FROM php:8-alpine

RUN apk update
RUN apk add git
RUN apk add make

WORKDIR /app

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# CMD ["/bin/sh"]

#CMD ["make", "install", "tests", "-f", "Makefile"]