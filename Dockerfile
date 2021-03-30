FROM php:7.4
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install sockets
WORKDIR /app
COPY . /app
EXPOSE 8000
RUN ["chmod", "+x", "/app/docker-entrypoint.sh"]
ENTRYPOINT ["sh", "/app/docker-entrypoint.sh"]