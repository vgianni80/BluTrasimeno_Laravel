FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip soap

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 8000

# Non eseguire artisan serve subito - aspetta che vendor esista
CMD if [ -d "vendor" ]; then php artisan serve --host=0.0.0.0 --port=8000; else echo "Run 'composer install' first" && tail -f /dev/null; fi