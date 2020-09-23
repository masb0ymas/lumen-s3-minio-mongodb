FROM php:7.3-fpm-alpine3.12
RUN docker-php-ext-install pdo mbstring sockets
RUN apk add --no-cache \
	$PHPIZE_DEPS \
	openssl-dev

# Setup Timezone
RUN	apk add tzdata
ENV TZ=Asia/Jakarta

# Setup GD extension
RUN apk update && apk add libpng-dev 
RUN apk add libwebp-dev \
	libpng-dev libxpm-dev \
	freetype-dev \
	libjpeg-turbo-dev 

RUN docker-php-ext-configure gd \
	--with-gd \
	--with-webp-dir \
	--with-jpeg-dir \
	--with-png-dir \
	--with-zlib-dir \
	--with-xpm-dir \
	--with-freetype-dir

RUN docker-php-ext-install gd

# Setup Zip, Excel
RUN apk add --no-cache zip libzip-dev
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

RUN apk add libxslt-dev
RUN docker-php-ext-install xsl

# Config php.ini
COPY ./php.ini $PHP_INI_DIR/php.ini

# Setup MongoDB & Redis
RUN pecl install mongodb
RUN pecl install redis
RUN docker-php-ext-enable mongodb redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www
WORKDIR /var/www

RUN composer install
# RUN php artisan swagger-lume:generate

EXPOSE 8080
CMD [ "php", "-S", "0.0.0.0:8080", "-t", "public/" ]
