FROM php:8.2-apache AS web

# Instalar dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Definir o diretório público do Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar os arquivos do projeto para o container
COPY . /var/www/html

# Mudar para o diretório do projeto
WORKDIR /var/www/html

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Definir permissões dos diretórios de cache e storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
