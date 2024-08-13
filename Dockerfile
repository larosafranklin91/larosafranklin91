FROM alpine:latest
RUN apk --update add --no-cache \
    curl \
    supervisor \
    sqlite \
    php82-apache2 \
    php82-cli \
    php82-common \
    php82-fpm \
    php82-zip \
    php82-gd \
    php82-mbstring \
    php82-curl \
    php82-xml \
    php82-bcmath \
    php82-pdo \
    php82-pdo_mysql \
    php82-pdo_sqlite \
    php82-phar \
    php82-openssl \
    php82-session \
    php82-tokenizer \
    php82-dom \
    php82-xmlwriter \
    php82-fileinfo \
    mysql-client \
    build-base \
    vim \
    nodejs-current \
    npm \
    yarn
RUN rm -Rf /var/cache/apk
RUN ln -s /usr/bin/php82 /usr/bin/php
RUN curl -sS https://getcomposer.org/installer | php82 -- --install-dir=/usr/bin --filename=composer
RUN mkdir -p /run/apache2
COPY supervisord.conf /etc/supervisord.conf
COPY httpd.conf /etc/apache2/httpd.conf
WORKDIR /var/www/localhost/htdocs
EXPOSE 80 443 8000
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
