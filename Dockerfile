FROM phpstorm/php-apache:8.2-xdebug3.2
COPY . /var/www/html

RUN docker-php-ext-install pdo pdo_mysql