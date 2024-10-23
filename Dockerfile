# Usar a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Habilitar o Apache mod_rewrite para o Laravel
RUN a2enmod rewrite

# Configurar o DocumentRoot para o Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Substituir a configuração padrão do Apache
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instalar dependências do Laravel
WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Definir permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta 80
EXPOSE 80

# Iniciar o Apache
CMD ["apache2-foreground"]
