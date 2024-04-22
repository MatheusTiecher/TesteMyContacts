# Use a imagem oficial do PHP 8.2 como base
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install system dependencies
RUN set -ex \
	&& apk --no-cache add git zip libzip-dev bash libjpeg-turbo-dev freetype-dev git-flow openssh postgresql-libs libpng-dev tzdata postgresql-dev gcc curl-dev $PHPIZE_DEPS \
	&& docker-php-ext-configure zip \
        && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install pgsql pdo_pgsql curl gd zip \
	&& apk del postgresql-dev curl-dev

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

RUN ln -snf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime && echo America/Sao_Paulo > /etc/timezone

# Install nodejs
RUN apk add --no-cache nodejs npm

EXPOSE 9000
CMD ["php-fpm"]
