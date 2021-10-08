FROM php:7.4-apache
ARG TARGET=production
ENV TARGET=${TARGET}
COPY . /var/www/html/
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y