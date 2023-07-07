FROM php:8.2-fpm-alpine

ENV APP_ENV=prod

WORKDIR /srv/app

# persistent / runtime deps
RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
	;

RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-data-full \
		icu-dev \
		libzip-dev \
		zlib-dev \
		postgresql-dev \
		libmcrypt-dev \
	# GD START
		libpng-dev \
		jpeg-dev \
		libwebp-dev \
        libjpeg-turbo-dev \
		freetype-dev \
		jpegoptim optipng pngquant gifsicle \
	# GD END
	; \
	### CONFIGURE PHP EXTENSIONS ###
	docker-php-ext-configure zip; \
	docker-php-ext-configure gd \
		--enable-gd \
		--with-jpeg \
		--with-webp \
		--with-freetype \
	; \
	### INSTALL PHP EXTENSIONS ###
	docker-php-ext-install -j$(nproc) \
		intl \
		zip \
		pgsql \
		pdo \
		pdo_pgsql \
		gd \
		exif \
	; \
	pecl install \
		apcu \
	; \
	pecl clear-cache; \
	docker-php-ext-enable \
		apcu \
		opcache \
	; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .app-phpexts-rundeps $runDeps; \
	\
	apk del .build-deps

CMD ["php-fpm"]

EXPOSE 9000