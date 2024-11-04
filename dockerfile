# Usando a imagem PHP 8.1 FPM como base
FROM php:8.1-fpm

# Instala as dependências e as extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pgsql pdo_pgsql zip

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Limpa o cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN chmod -R 755 ./app/public

RUN chown -R www-data:www-data ./app/storage ./app/bootstrap/cache
