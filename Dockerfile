# FROM php:8.0 as php

# RUN apt-get update -y
# RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
# RUN docker-php-ext-install pdo pdo_mysql bcmath

# # RUN mkdir -p /var/www/public/storage \
# #     && ln -s /var/www/storage/app/public /var/www/public/storage
# #RUN ln -s /var/www/storage/app/public /var/www/public/storage

# RUN pecl install -o -f redis \
#     && rm -rf /tmp/pear \
#     && docker-php-ext-enable redis

# WORKDIR /var/www
# COPY . .
# COPY --from=composer:2.4.2 /usr/bin/composer /usr/bin/composer

# ENV PORT=8000
# ENTRYPOINT [ "docker/entrypoint.sh" ]

# FROM node:14-alpine as node

# WORKDIR /var/www
# COPY . .

# RUN composer install --ignore-platform-reqs --no-scripts --no-autoloader
# RUN php artisan migrate:fresh --seed
# RUN php artisan storage:link
# RUN npm install
# RUN npm run dev

# RUN php artisan breeze:install

# VOLUME /var/www/node_modules