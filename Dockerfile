FROM php:7.0-fpm

RUN apt-get update \
    && apt-get -y install \
            libicu52 \
            libicu-dev \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libpng12-dev \

            git \
            zlib1g-dev \
        --no-install-recommends \

    && docker-php-ext-install -j$(nproc) intl \

    && docker-php-ext-install -j$(nproc) bcmath \

    && docker-php-ext-install -j$(nproc) pdo pdo_mysql \

    && docker-php-ext-install mbstring bcmath \

    && docker-php-ext-install -j$(nproc) opcache \
    && pecl install apcu-5.1.8 && docker-php-ext-enable apcu \

    && docker-php-ext-install -j$(nproc) zip \

     && docker-php-ext-configure gd \
                --with-gd \
                --with-freetype-dir=/usr \
                --with-png-dir=/usr \
                --with-jpeg-dir=/usr \
        && docker-php-ext-install -j$(nproc) gd \

    && apt-get purge -y \
        icu-devtools \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/*

# Install composer
COPY install-composer /install-composer
RUN /install-composer && rm /install-composer && composer self-update && composer clear-cache \
	&& composer global require "fxp/composer-asset-plugin:^1.3.1"
