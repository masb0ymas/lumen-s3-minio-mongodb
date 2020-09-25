FROM webdevops/php-nginx:7.3-alpine
RUN docker-php-ext-install pdo mbstring sockets
RUN apk add --no-cache \
	$PHPIZE_DEPS \
	openssl-dev

# Setup Timezone
RUN	apk add tzdata
ENV TZ=Asia/Jakarta
ENV WEB_DOCUMENT_ROOT=/var/www/public

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

RUN apk add --no-cache zip libzip-dev
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

RUN apk add libxslt-dev
RUN docker-php-ext-install xsl

RUN docker-php-ext-enable mongodb redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www
WORKDIR /var/www
RUN chown -R application:application .

RUN composer install
# RUN php artisan swagger-lume:generate

# EXPOSE 8080
# CMD [ "php", "-S", "0.0.0.0:8080", "-t", "public/" ]
