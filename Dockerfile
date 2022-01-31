FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy all of the file in folder to /src
COPY . /src
WORKDIR /src

RUN composer update
CMD php artisan serve --host 0.0.0.0
# run the php server service
# move this command to -> docker-compose.yml
# CMD php -S 0.0.0.0:8080 public/index.php