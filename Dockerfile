FROM php:7.4-fpm-alpine

# for laravel lumen run smoothly
RUN apk --no-cache add \
    php7 \
    php7-fpm \
    php7-pdo \
    php7-mbstring \
    php7-openssl

# for composer & our project depency run smoothly
RUN apk --no-cache add \
    php7-phar \
    php7-xml \
    php7-xmlwriter

# for swagger run smoothly
RUN apk --no-cache add \
    php7-tokenizer

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql


# if need composer to update plugin / vendor used
RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"